const card_holder = document.querySelector('#contact-holder');
const search = document.querySelector('#searchbar');
search.addEventListener('change', processSearch);

function generateCard(cardData) {
    const card = document.createElement('div');
    card.classList.add('card');
    fillCard(card, cardData);
    return card;
}

function cancelEdit(cardData, event) {
    const card = event.target.parentElement;
    clearCard(card);
    fillCard(card, cardData);
}

function clearCard(card) {
    let child = card.lastElementChild;
    while (child) {
        card.removeChild(child);
        child = card.lastElementChild;
    }
}

function fillCard(card, cardData) {
    let names = ['body', 'name', 'email', 'phone', 'date'];

    let elements = {};
    elements['card'] = card;
    for (const _name of names) {
        elements[_name] = document.createElement('div');
    }

    elements['edit'] = document.createElement('button');

    let parent_children = {
        'card': ['body', 'date', 'edit'],
        'body': ['name', 'email', 'phone']
    };

    for (const _parent in elements) {
        if (parent_children[_parent] === undefined) continue;

        for (const _child of parent_children[_parent]) {
            elements[_parent].appendChild(elements[_child]);
        }
    }

    elements['name'].innerHTML = cardData['name'];
    elements['email'].innerHTML = cardData['email'];
    elements['phone'].innerHTML = cardData['phone'];
    elements['date'].innerHTML = cardData['date'];
    elements['edit'].innerHTML = '✏️';

    elements['card'].classList.add('card');
    elements['body'].classList.add('main');
    elements['name'].classList.add('card-title','name');
    elements['email'].classList.add('email');
    elements['phone'].classList.add('phone');
    elements['date'].classList.add('card-subtitle', 'date');
    elements['edit'].classList.add('edit');

    elements['edit'].addEventListener('click', editCard.bind(this, cardData));
    return elements['card'];
}

function editCard(cardData, event) {
    const card = event.target.parentElement;
    let names = ['body'];
    let elements = {};
    elements['card'] = card;
    elements['body'] = document.createElement('div');

    let fields = ['name', 'email', 'phone'];
    for (const _field of fields) {
        elements[_field] = document.createElement('input');
    }

    let buttons = ['delete', 'update', 'cancel'];
    for (const _button of buttons) {
        elements[_button] = document.createElement('button');
    }

    let parent_children = {
        'card': ['body', 'cancel', 'delete', 'update'],
        'body': ['name', 'email', 'phone']
    };

    clearCard(elements['card']);

    for (const _parent in elements) {
        if (parent_children[_parent] === undefined) continue;
        for (const _child of parent_children[_parent]) {
            elements[_parent].appendChild(elements[_child]);
        }
    }

    elements['name'].placeholder = 'Name';
    elements['email'].placeholder = 'Email';
    elements['phone'].placeholder = 'Phone #';

    elements['cancel'].innerHTML = 'x';
    elements['delete'].innerHTML = 'Delete';
    elements['update'].innerHTML = 'Update';

    elements['card'].classList.add('card');
    elements['body'].classList.add('main');
    elements['name'].classList.add('card-title','name');
    elements['email'].classList.add('email');
    elements['phone'].classList.add('phone');
    elements['cancel'].classList.add('cancel');
    elements['delete'].classList.add('delete');
    elements['update'].classList.add('update');

    elements['cancel'].addEventListener('click', cancelEdit.bind(this, cardData));
    elements['delete'].addEventListener('click', deleteCard.bind(this, cardData));
    elements['update'].addEventListener('click', updateCard.bind(this, cardData));
    console.log(card);
}

function deleteCard(cardData, event) {
    // delete from database

    // upon success
    event.target.parentElement.remove();
}

function updateCard(cardData, event) {
    const card = event.target.parentElement;
    
    const updatedData = {
        'name': card.querySelector('.name').value,
        'email': card.querySelector('.email').value,
        'phone': card.querySelector('.phone').value,
    };
    
    // process, check validity

    // send to api

    // upon success continue


    for (const _name in updatedData) {
        cardData[_name] = updatedData[_name];
    }
    
    clearCard(card);
    fillCard(card, cardData);
}


function processSearch(event) {
    const query = event.target.value;
    
    // access api
    let data = [
        {
            'name': 'Joran James',
            'email': 'yellowj@gmail.com',
            'phone': '9545841023',
            'date': '02/10/2023',
            'id': '00001'
        },
        {
            'name': 'Kyre Korn',
            'email': 'kylecochran123@gmail.com',
            'phone': '3052981486',
            'date': '05/24/2001',
            'id': '00002'
        }
    ];
    // clear cards
    const template = card_holder.lastElementChild;
    card_holder.removeChild(template);

    let child = card_holder.lastElementChild;
    while (child) {
        card_holder.removeChild(child);
        child = card_holder.lastElementChild;
    }

    // generate new cards
    for (const entry of data) {
        const card = generateCard(entry);
        card_holder.appendChild(card);
    }

    card_holder.appendChild(template);
}


