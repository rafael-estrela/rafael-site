/**
 * Creates the entire form structure for every trivia addition.
 */
function addTrivia() {
    let id = fieldId(25, 'valueInput-')

    if (id < 1) {
        notifyLimit('add-trivia')

        return
    }

    let deleteLabel = document.createElement('label')
    updateElementAttr(deleteLabel, 'id', `delete-trivia-${id}`)

    let deleteImg = document.createElement('img')
    updateElementAttr(deleteImg, 'src', '/rafael-site/data/image/icons/remove.png')
    updateElementAttr(deleteImg, 'class', 'mng-link')
    updateElementAttr(deleteImg, 'onclick', `removeTrivia(${id})`)

    deleteLabel.appendChild(deleteImg)

    let container = document.createElement('div')
    updateElementAttr(container, 'class', 'form-group')

    let input = document.createElement('input')
    updateElementAttr(input, 'type', 'text')
    updateElementAttr(input, 'name', `value-${id}`)
    updateElementAttr(input, 'class', 'form-control form-control-user')
    updateElementAttr(input, 'id', `valueInput-${id}`)
    updateElementAttr(input, 'required', '')
    updateElementAttr(input, 'maxlength', '100')
    updateElementAttr(input, 'placeholder', 'O que precisam saber sobre você?')

    container.appendChild(input)

    let divider = document.createElement('hr')
    updateElementAttr(divider, 'id', `divider-${id}`)

    let form = getElement('form-content')
    form.insertBefore(divider, getElement('add-trivia').parentElement)
    form.insertBefore(container, divider)
    form.insertBefore(deleteLabel, container)
}

/**
 * removes a trivia group from the form. Also rewrites the current IDs to keep the order.
 * @param id trivia group id.
 */
function removeTrivia(id) {
    let form = getElement('form-content')

    removeChild(form, 'delete-trivia-', id)
    form.removeChild(getElement('valueInput-', id).parentElement)
    removeChild(form, 'divider-', id)

    let values = initialId(id, 25, 'valueInput-')
    let initial = values[0]
    let last = values[1]

    if (initial >= 1) {
        for(let index = initial; index <= last; index++) {
            let newIndex = index - 1

            let deleteTrivia = getElement('delete-trivia-', index)
            updateId(index, newIndex, 'delete-trivia-')
            updateElementAttr(deleteTrivia.firstElementChild, 'onclick', `removeTrivia(${newIndex})`)

            updateId(index, newIndex, 'divider-')

            let input = getElement('valueInput-', index)
            updateId(index, newIndex, 'valueInput-')
            updateElementAttr(input, 'name', `value-${newIndex}`)
        }
    }
}