// Support variables

let typeArray = null

// Support functions

/**
 * Escapes the regex characters in the pattern.
 * @param pattern string to escape characters.
 * @returns pattern with escaped characters.
 */
function escapedPattern(pattern) {
    return pattern.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Request functions

/**
 * called every time the user selects a different type.
 * @param selected select input.
 * @param id link group identifier.
 */
function didChangeType(selected, id) {
    switch (selected.value) {
        case "":
            appendBaseUrl('Url...', id)
            break
        default:
            if (typeArray == null) {
                loadTypeArray(function(response) {
                    typeArray = response.data

                    let selection = typeArray.filter(function(type) {
                        return type.id == selected.value
                    })[0]

                    appendBaseUrl(selection.baseUrl, id)
                }, function(response) {
                    let error = response.responseJSON.error

                    displayErrorMessage(error)
                })
            } else {
                let selection = typeArray.filter(function(type) {
                    return type.id == selected.value
                })[0]

                appendBaseUrl(selection.baseUrl, id)
            }

            break
    }
}

// UI modifiers

/**
 * Creates the entire form structure for every link addition.
 */
function addLink() {
    let id = fieldId(5, 'proj-link-')

    if (id < 1) {
        notifyLimit('add-link')

        return
    }

    let group = document.createElement('div')
    updateElementAttr(group, 'class', 'form-group row')
    updateElementAttr(group, 'id', `proj-link-${id}`)

    let linkField = document.createElement('input')
    updateElementAttr(linkField, 'type', 'text')
    updateElementAttr(linkField, 'class', 'form-control form-control-user')
    updateElementAttr(linkField, 'required', '')
    updateElementAttr(linkField, 'maxlength', '100')
    updateElementAttr(linkField, 'placeholder', 'Url...')
    updateElementAttr(linkField, 'name', `proj-link-${id}`)

    let linkContainer = document.createElement('div')
    updateElementAttr(linkContainer, 'class', 'col-sm-12 mb-3 mb-sm-0')
    updateElementAttr(linkContainer, 'id', `url-container-${id}`)

    linkContainer.appendChild(linkField)

    group.appendChild(linkContainer)

    let row = document.createElement('div')
    updateElementAttr(row, 'class', 'form-group row')
    updateElementAttr(row, 'id', `type-select-container-${id}`)

    let loader = document.createElement('i')
    loader.id = `select-loader-${id}`
    loader.className = 'fa-spin fas fa-spinner close m-auto fa-fw invisible'
    row.appendChild(loader)

    let firstColumn = document.createElement('div')
    updateElementAttr(firstColumn, 'class', 'col-sm-11 mb-3 mb-sm-0')

    addSelectTo(firstColumn, id, loader)

    row.insertBefore(firstColumn, loader)

    let form = getElement('form-content')

    let hr = document.createElement('hr')
    updateElementAttr(hr, 'id', `divider-${id}`)

    let linkDeleter = document.createElement('img')
    updateElementAttr(linkDeleter, 'onclick', `removeLink(${id})`)
    updateElementAttr(linkDeleter, 'src', '/rafael-site/data/image/icons/remove.png')
    updateElementAttr(linkDeleter, 'class', 'mng-link')

    let delWrap = document.createElement('label')
    updateElementAttr(delWrap, 'id', `delete-link-${id}`)
    delWrap.appendChild(linkDeleter)

    form.insertBefore(hr, getElement('add-link').parentElement)
    form.insertBefore(group, hr)
    form.insertBefore(row, group)
    form.insertBefore(delWrap, row)
}

/**
 * removes a link group from the form. Also rewrites the current IDs to keep the order.
 * @param id link group id
 */
function removeLink(id) {
    let form = getElement('form-content')

    removeChild(form, 'type-select-container-', id)
    removeChild(form, 'proj-link-', id)
    removeChild(form, 'delete-link-', id)
    removeChild(form, 'divider-', id)
    removeChild(form, 'type-img-tmp-url-', id)
    removeChild(form, 'link-id-', id)

    let values = initialId(id,5, 'proj-link-')
    let initial = values[0]
    let last = values[1]

    if (initial >= 1) {
        for(let index = initial; index <= last; index++) {
            let newIndex = index - 1

            let deleteLink = getElement('delete-link-', index)
            updateId(index, newIndex, 'delete-link-')
            updateElementAttr(deleteLink.firstElementChild, 'onclick', `removeLink(${newIndex})`)

            let select = getElement('type-select-', index)
            updateId(index, newIndex, 'type-select-')
            updateElementAttr(select, 'onchange', `didChangeType(this, ${newIndex})`)
            updateElementAttr(select, 'name', `type-select-${newIndex}`)

            updateId(index, newIndex, 'type-select-container-')
            updateId(index, newIndex, 'proj-link-')

            updateElementAttr(
                getElement('url-container-', index).firstElementChild,
                'name', `proj-link-${newIndex}`
            )
            updateId(index, newIndex, 'url-container-')

            updateId(index, newIndex, 'divider-')

            updateAttr(index, 'type-img-tmp-url-', 'name', `type-img-tmp-url-${newIndex}`)
            updateId(index, newIndex, 'type-img-tmp-url-')

            updateAttr(index, 'type-input-name-', 'name', `custom-type-${newIndex}`)
            updateId(index, newIndex, 'type-input-name-')
        }
    }
}

/**
 * creates and inserts a select field to the link form structure.
 * @param row field container.
 * @param id link group id.
 */
function addSelectTo(row, id, loader) {
    let select = document.createElement('select')
    updateElementAttr(select, 'id', `type-select-${id}`)
    updateElementAttr(select, 'name', `type-select-${id}`)
    updateElementAttr(select, 'class', 'custom-select form-control-user')
    updateElementAttr(select, 'onchange', `didChangeType(this, ${id})`)

    let firstOption = document.createElement('option')
    updateElementAttr(firstOption, 'value', '')
    firstOption.innerHTML = 'Selecione a plataforma de distribuição'

    select.appendChild(firstOption)

    if (typeArray == null) {
        loader.classList.remove('invisible')

        loadTypeArray(function(response) {
            removeLoaderAndEnlarge(loader)

            typeArray = response.data

            insertOptions(select)

            row.appendChild(select)
        }, function(response) {
            loader.classList.add('invisible')

            let error = response.responseJSON.error

            displayErrorMessage(error)
        })
    } else {
        insertOptions(select)
        row.appendChild(select)

        setTimeout(function() {
            removeLoaderAndEnlarge(loader)
        }, 100)
    }
}

/**
 * Inserts the loaded types as options for the declared select.
 * @param select input container for the options.
 */
function insertOptions(select) {
    typeArray.forEach(function(v, k) {
        addOptionTo(select, v.id, v.name)
    })
}

/**
 * inserts an option to a defined select field.
 * @param select select field.
 * @param value option value.
 * @param inner option inner HTML.
 */
function addOptionTo(select, value, inner) {
    let option = document.createElement('option')
    updateElementAttr(option,'value', value)
    option.innerHTML = inner

    select.appendChild(option)
}

/**
 * Sets up the placeholders/texts for custom link types.
 * @param baseUrl type's base URL.
 * @param id link group id.
 */
function appendBaseUrl(baseUrl, id) {
    let container = getElement('url-container-', id)

    if (baseUrl === 'Url...') {
        container.firstElementChild.removeAttribute('pattern')
        container.firstElementChild.removeAttribute('title')
    } else {
        updateElementAttr(container.firstElementChild, 'pattern', `${escapedPattern(baseUrl)}.+`)
        updateElementAttr(container.firstElementChild, 'title', `Esse link deve começar com ${baseUrl} ;)`)
    }
}

function removeLoaderAndEnlarge(loader) {
    let container = loader.parentElement
    container.removeChild(loader)

    let input = container.firstElementChild
    input.className = 'col-sm-12 mb-3 mb-sm-0'
}

function loadTypeArray(onSuccess, onError) {
    $.ajax({
        type: 'GET',
        url: '/rafael-site/api/project/types/',
        processData: false,
        contentType: false,
        success: onSuccess,
        error: onError
    })
}