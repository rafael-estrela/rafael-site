function didChangeName(input) {
    let idInput = document.getElementById('form-content').firstElementChild
    idInput.value = ""

    let name = input.value

    let textElement = getElement('graph-preview').firstElementChild

    if (name === '') {
        removeList()
        textElement.innerText = "Preview"
        return
    }

    loadingList()

    textElement.innerText = name

    if (counter != 0) {
        clearTimeout(counter)
        counter = 0
    }

    counter = setTimeout(function() {
        $.ajax({
            type: 'GET',
            url: `/rafael-site/api/skill/list/${name}`,
            processData: false,
            contentType: false,
            success: function(response) {
                updateList(response.data)
            }, error: function(response) {
                let error = response.responseJSON.error

                displayErrorMessage(error)
            }
        })
    }, 500)
}

function didSelect(entry) {
    let idInput = document.getElementById('form-content').firstElementChild
    idInput.value = entry.skillId

    let nameInput = document.getElementById('name-container').firstElementChild
    nameInput.value = entry.name

    let textElement = getElement('graph-preview').firstElementChild
    textElement.innerText = entry.name
}

function didChangePercent(input) {
    let preview = getElement('graph-preview')

    let percent = input.value

    if (!isNaN(percent)) {
        percent /= 10
        let percentTextElement = preview.lastElementChild

        let floorPercent = Math.round(percent)
        let text = ''

        for(let i = 0; i < 10; i++) {
            if (i < floorPercent) {
                text += "&#9733; "
            } else {
                text += "&#x2606; "
            }
        }

        percentTextElement.innerHTML = text
    }
}

function loadingList() {
    let nameContainer = document.getElementById('name-container')

    if (nameContainer.lastElementChild.id === 'list-container') return

    let listContainer = document.createElement('div')

    listContainer.id = 'list-container'
    listContainer.innerHTML = '<p>Carregando...</p>'

    stylizeList(nameContainer, listContainer)

    nameContainer.appendChild(listContainer)
}

function stylizeList(nameContainer, listContainer) {
    let nameField = nameContainer.firstElementChild
    let topSpacing = nameField.offsetHeight+4

    listContainer.style.width = nameField.offsetWidth+'px'
    listContainer.style.maxHeight = '12em'
    listContainer.style.overflow = 'scroll'
    listContainer.style.position = 'absolute'
    listContainer.style.top = topSpacing+'px'
    listContainer.style.backgroundColor = '#FFF'
    listContainer.style.boxShadow = '2px 2px 5px 1px black'
    listContainer.style.borderRadius = '0 0 5px 5px'
    listContainer.style.zIndex = 999
}

function removeList() {
    let nameContainer = document.getElementById('name-container')
    let listContainer = nameContainer.lastElementChild

    if (listContainer.id === 'list-container') {
        nameContainer.removeChild(nameContainer.lastElementChild)
    }
}

function updateList(entries) {
    let listContainerElement = document.getElementById('list-container')
    listContainerElement.innerHTML = ""

    if (entries.length > 0) {
        listContainerElement.appendChild(listItem(null))
    }

    entries.forEach(function(entry) {
        listContainerElement.appendChild(listItem(entry))
    })
}

function listItem(entry) {
    let element = document.createElement('div')

    if (entry == null) {
        element.innerHTML = "<span>Selecione uma opção</span>"
    } else {
        element.innerHTML = "<span>"+entry.name+"</span>"

        element.onclick = function() {
            didSelect(entry)
        }

        element.style.cursor = 'pointer'
    }

    element.style.borderBottom = '1px solid #f8f9fc'
    element.style.padding = "5px"

    return element
}

function focusOnName(focusing) {
    let listContainer = document.getElementById('list-container')

    if (listContainer) {
        if (focusing) {
            listContainer.style.visibility = 'visible'
        } else {
            setTimeout(function() {
                listContainer.style.visibility = 'hidden'
            }, 100)
        }
    }
}