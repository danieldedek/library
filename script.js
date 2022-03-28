window.onload = function(){
    let authorNameDiv = document.getElementById('authorNameDiv');
    let addFieldsAuthor = document.getElementById('addFieldsAuthor');
    let removeFieldsAuthor = document.getElementById('removeFieldsAuthor');

    let imperfectionDiv = document.getElementById('imperfectionDiv');
    let addFieldsImperfection = document.getElementById('addFieldsImperfection');
    let removeFieldsImperfection = document.getElementById('removeFieldsImperfection');

    addFieldsAuthor.onclick = function() {
        let labelTags = authorNameDiv.getElementsByTagName('label');
        let inputTags = authorNameDiv.getElementsByTagName('input');

        if(labelTags.length < 5) {
            let newlabel = document.createElement('label');
            newlabel.setAttribute('for', 'authorName');
            newlabel.innerHTML = "Jméno autora:";
            authorNameDiv.appendChild(newlabel);
        }
        
        if(inputTags.length < 5) {
            let newField = document.createElement('input');
            newField.setAttribute('type', 'text');
            newField.setAttribute('name', 'authorName[]');
            newField.setAttribute('class', 'input');
            authorNameDiv.appendChild(newField);
        }
    }

    removeFieldsAuthor.onclick = function() {
        let labelTags = authorNameDiv.getElementsByTagName('label');
        let inputTags = authorNameDiv.getElementsByTagName('input');
        if(labelTags.length > 1)
            authorNameDiv.removeChild(labelTags[(labelTags.length - 1)]);
        if(inputTags.length > 1)
            authorNameDiv.removeChild(inputTags[(inputTags.length - 1)]);
    }

    addFieldsImperfection.onclick = function() {
        let labelTags = imperfectionDiv.getElementsByTagName('label');
        let inputTags = imperfectionDiv.getElementsByTagName('input');

        if(labelTags.length < 5) {
            let newlabel = document.createElement('label');
            newlabel.setAttribute('for', 'imperfection');
            newlabel.innerHTML = "Závada:";
            imperfectionDiv.appendChild(newlabel);
        }
        
        if(inputTags.length < 5) {
            let newField = document.createElement('input');
            newField.setAttribute('type', 'text');
            newField.setAttribute('name', 'imperfection[]');
            newField.setAttribute('class', 'input');
            imperfectionDiv.appendChild(newField);
        }
    }

    removeFieldsImperfection.onclick = function() {
        let labelTags = imperfectionDiv.getElementsByTagName('label');
        let inputTags = imperfectionDiv.getElementsByTagName('input');
        if(labelTags.length > 0)
            imperfectionDiv.removeChild(labelTags[(labelTags.length - 1)]);
        if(inputTags.length > 0)
            imperfectionDiv.removeChild(inputTags[(inputTags.length - 1)]);
    }
}