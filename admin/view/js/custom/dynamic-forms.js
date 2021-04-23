// Support functions

/**
 * Locates the biggest identifier for the desired group.
 * @param limit max elements.
 * @param prefix field identifier prefix.
 * @param first initial id to start mapping.
 * @returns the next available identifier.
 */
function fieldId(limit, prefix, first = 1) {
    let foundLast = false
    let id = first

    while(!foundLast && id <= limit) {
        let container = getElement(prefix, id)

        if (container == null) {
            foundLast = true
        } else {
            id++
        }
    }

    if (id > limit) return -1

    return id
}

/**
 * Locates the first group id.
 * @param limit max elements.
 * @param prefix field identifier prefix.
 * @returns the first detected identifier.
 */
function firstId(limit, prefix) {
    let foundFirst = false
    let id = 1

    while(!foundFirst && id <= limit) {
        let container = getElement(prefix, id)

        if (container != null) {
            foundFirst = true
        } else {
            id++
        }
    }

    if (id > limit) return -1
    return id
}

/**
 * Locates the last group id.
 * @param first the group id, to base search on
 * @param limit max elements.
 * @param prefix field identifier prefix.
 * @returns the first detected identifier.
 */
function lastId(first, limit, prefix) {
    let counter = 1
    let id = first

    while(counter <= limit) {
        let container = getElement(prefix, counter)

        if (container != null) {
            id = counter
        }

        counter++
    }

    if (id > limit) return -1

    return id
}

/**
 * Finds the first and last group id to start form update.
 * @param removedId removed group identifier.
 * @param limit max elements.
 * @param prefix field identifier prefix.
 * @returns the initial and final id to update the form.
 */
function initialId(removedId, limit, prefix) {
    let initial = -1;
    let first = firstId(limit, prefix)
    let last = lastId(first, limit, prefix)

    if (removedId < last) {
        if (removedId < first) {
            initial = first
        } else {
            initial = removedId + 1
        }
    }

    return [initial, last]
}

/**
 * Returns an element based on prefix and id.
 * If no id is set, the prefix is considered as the element id.
 * @param prefix element id prefix.
 * @param id optional link group id.
 */
function getElement(prefix, id = -1) {
    if (id === -1) return document.getElementById(prefix)

    return document.getElementById(prefix + id)
}

/**
 * Changes the id of an element with a new id, created by a prefix and the new link group id.
 * @param currId current link group id.
 * @param newId new link group id.
 * @param prefix element id prefix.
 */
function updateId(currId, newId, prefix) {
    updateAttr(currId, prefix, 'id', prefix + newId)
}

/**
 * Updates an element's attribute.
 * @param currId link group id.
 * @param prefix element id prefix.
 * @param attr attribute to be changed.
 * @param value attr new value.
 */
function updateAttr(currId, prefix, attr, value) {
    let element = document.getElementById(prefix + currId)

    if (element != null) {
        updateElementAttr(element, attr, value)
    }
}

/**
 * Updates an attribute of an element.
 * @param element attribute holder.
 * @param attr attribute to be changed.
 * @param value new value for attribute.
 */
function updateElementAttr(element, attr, value) {
    element.setAttribute(attr, value)
}

/**
 * Removes a child from a container, if both are not null.
 * @param container child container.
 * @param prefix child id prefix.
 * @param id link group id.
 */
function removeChild(container, prefix, id) {
    let child = document.getElementById(prefix + id)

    if (container != null && child != null) {
        container.removeChild(child)
    }
}

/**
 * Tints a identified label in red for a short time.
 * @param identifier element id.
 */
function notifyLimit(identifier) {
    let label = getElement(identifier).parentElement
    label.style.color = '#FF3300'

    setTimeout(function() {
        label.style.color = '#858796'
    }, 1500)
}