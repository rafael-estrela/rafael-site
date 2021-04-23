// Support vars
let counter = 0

// UI Modifiers
function didChangeState(checkbox, target) {
    let element = document.getElementById(target)

    if (checkbox.checked) {
        element.setAttribute("disabled", "")
        element.removeAttribute('required')
    } else {
        element.removeAttribute("disabled")
        element.setAttribute('required', '')
    }
}

function removeError(container) {
    let err = document.getElementById('alert-err')

    if (err != null) container.removeChild(err)
}

function appendError(container, error) {
    removeError(container)

    let newErr = document.createElement('div')
    newErr.setAttribute('id', 'alert-err')
    newErr.setAttribute('class', 'alert alert-danger')
    newErr.innerHTML = error

    container.insertBefore(newErr, container.firstChild)
}

function countCharacters(input, id, max) {
    let counterLabel = document.getElementById(id);
    let current = input.value.length

    counterLabel.innerText = `${current}/${max}`;

    if (current > max) {
        counterLabel.style.color = '#FF3300';
    } else {
        counterLabel.style.color = '#858796'
    }

    return current < max;
}

function maskInput(input, mask) {
    try {
        let value = input.value;
        let literalPattern=/[0\*]/;
        let numberPattern=/[0-9]/;
        let newValue = "";

        for (let vId = 0, mId = 0; mId < mask.length;) {
            if (mId >= value.length)
                break;

            // Number expected but got a different value, store only the valid portion
            if (mask[mId] == '0' && value[vId].match(numberPattern) == null) {
                break;
            }

            // Found a literal
            while (mask[mId].match(literalPattern) == null) {
                if (value[vId] == mask[mId])
                    break;

                newValue += mask[mId++];
            }

            newValue += value[vId++];
            mId++;
        }

        input.value = newValue;
    } catch(e) {}
}

function copyMyLink(username) {
    let placeholder = document.createElement('input')
    placeholder.value = `http://localhost/rafael-site/user/${username}/`

    document.body.appendChild(placeholder)
    placeholder.select()
    document.execCommand('copy')

    document.body.removeChild(placeholder)

    let alert = document.getElementById('userAlert')
    alert.style.opacity = 1

    setTimeout(function() {
        alert.style.opacity = 0
    }, 2000)
}

function displayErrorMessage(error) {
    let errorDiv = document.getElementById('userError')
    errorDiv.innerText = error
    errorDiv.style.opacity = 1

    setTimeout(function() {
        errorDiv.style.opacity = 0
    }, 2000)
}

function scheduleUsernameSearch(input) {
    let username = input.value
    let img = document.getElementById('usernameIndicator')

    if (!username.match(/^[a-zA-Z0-9_.-]{1,32}$/g)) {
        input.classList.remove('alert-success')
        input.classList.add('alert-danger')
        img.setAttribute('src', '/rafael-site/data/image/icons/error.png')

        return
    }

    if (counter != 0) {
        clearTimeout(counter)
        counter = 0
    } else {
        img.setAttribute('src', '/rafael-site/data/image/icons/loading.png')
        img.classList.add('loader')
    }

    counter = setTimeout(function() {
        $.ajax({
            url: `/rafael-site/api/settings/username/${username}/`,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(response) {
                img.classList.remove('loader')
                counter = 0

                let available = response.data

                if (available) {
                    input.classList.remove('alert-danger')
                    input.classList.add('alert-success')
                    img.setAttribute('src', '/rafael-site/data/image/icons/success.png')

                    input.removeAttribute('title')
                } else {
                    input.classList.remove('alert-success')
                    input.classList.add('alert-danger')
                    img.setAttribute('src', '/rafael-site/data/image/icons/error.png')

                    input.setAttribute('title', response.error)
                }
            }, error: function(response) {
                console.log(response)
                
                img.classList.remove('loader')
                counter = 0

                let error = response.responseJSON.error

                displayErrorMessage(error)

                input.classList.remove('alert-success')
                input.classList.add('alert-danger')
            }
        })
    }, 500)
}