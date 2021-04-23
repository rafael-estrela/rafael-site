// Support structures

let gValues = {
    "ajax": "/rafael-site/api/graduation/image/upload/",
    "def": "/rafael-site/data/image/graduation/default.jpg"
}

let wValues = {
    "ajax": "/rafael-site/api/work/image/upload/",
    "def": "/rafael-site/data/image/work/default.jpg"
}

let pValues = {
    "ajax": "/rafael-site/api/project/image/upload/",
    "def": "/rafael-site/data/image/project/default.jpg"
}

let lValues = {
    "ajax": "/rafael-site/api/register/image/upload/",
    "def": "/rafael-site/data/image/profile/default.jpg"
}

let targets = {
    "g": gValues,
    "w": wValues,
    "p": pValues,
    "l": lValues
}

// Request functions
function didUploadImage(input, srvc, containerId = 'form-body', loaderId = 'img-loader') {
    let container = document.getElementById(containerId)

    let loader = document.getElementById(loaderId)
    loader.classList.remove("invisible")

    let data = new FormData();
    data.append('formData', input.files[0]);

    $.ajax({
        url: targets[srvc]["ajax"],
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            loader.classList.add("invisible")

            let url = response.data

            removeError(container)

            updateImage(url)
            appendImage(url, srvc)
        }, error: function(response) {
            loader.classList.add("invisible")
            
            let error = response.responseJSON.error

            appendError(container, error)
            resetValue()
        }
    })
}

// UI modifiers
function updateImage(url) {
    let img = document.getElementById('image-preview')

    img.removeAttribute('src')
    img.setAttribute('src', url)
}

function removeImage(content) {
    let field = document.getElementById('img_tmp_url')

    if (field != null) content.removeChild(field)

    removeImageRemoveOption(document.getElementById('img-preview-header'))
}

function appendImage(url, srvc) {
    let content = document.getElementById('form-content')

    removeImage(content)

    let field = document.createElement('input')
    field.setAttribute('id', 'img_tmp_url')
    field.setAttribute('type', 'hidden')
    field.setAttribute('name', 'img-url')
    field.setAttribute('value', url)

    content.insertBefore(field, content.firstChild)

    appendImageRemoveOption(document.getElementById('img-preview-header'), srvc)
}

function appendImageRemoveOption(header, srvc) {
    let btn = document.createElement('button')
    btn.setAttribute('class', 'close')
    btn.setAttribute('onclick', "didClearImage('"+srvc+"')")
    btn.innerHTML = '<i class="fas fa-trash-alt fa-sm fa-fw"></i>';

    header.appendChild(btn)
}

function removeImageRemoveOption(header) {
    if (header.lastElementChild.tagName === 'BUTTON')
        header.removeChild(header.lastElementChild)
}

function didClearImage(srvc) {
    let content = document.getElementById('form-content')

    removeImage(content)
    updateImage(targets[srvc]["def"])

    resetValue()
}

function resetValue() {
    document.getElementById('img_input_file').value = ''
}
