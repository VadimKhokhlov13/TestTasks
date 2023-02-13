const participants = [];

document.getElementById('input').addEventListener('keypress', function(e) {
    if (e.keyCode == 13) {
        document.getElementById("button").click();
    }
    let that = this;
    setTimeout(() => {
        var res = /[^А-Яа-я,]/g.exec(that.value);
        that.value = that.value.replace(res, "");
        if (res) {
            alert("Доступны только кириллические буквы и запятая");
        }
    }, 0);
})

document.getElementById('button').addEventListener('click', function() {
    let inputVal = document.getElementById('input').value;
    let newParticipants = inputVal.split(',').filter(part => part);
    document.getElementById('input').value = "";
    addParticipants(newParticipants);
    createTable();
})

const ids = ['id', 'name', 'points'];
let orderBy = 'ASC';
ids.forEach(el => {
    document.getElementById(el).addEventListener('click', function(e) {
        e.preventDefault();
        let sortedKey = this.id;
        sortParticipants(sortedKey);
        orderBy = orderBy === 'ASC' ? 'DESC' : 'ASC';
        createTable();
    })
})

function addParticipants(newParticipants) {
    let id = participants.length + 1;
    newParticipants.forEach(name => {
        let points = Math.round(Math.random() * 100);
        participants.push({id, name, points})
        id++;
    });
}

function sortParticipants(key) {
    if (key === 'id' || key === 'points') {
        participants.sort((a, b) => {
            if (orderBy === 'ASC') {
                return b[key] - a[key];
            } else {
                return a[key] - b[key];
            }
        })
    } else {
        const ruCollator = new Intl.Collator('ru-RU');
        participants.sort((a, b) => {
            if (orderBy === 'ASC') {
                return ruCollator.compare(a[key], b[key])
            } else {
                return ruCollator.compare(b[key], a[key])
            }
        })
    }
}

function createTable() {
    if (participants.length > 0) {
        document.getElementById('tableContainer').setAttribute('style', 'display:block !important');
    }
    let tableBody = document.getElementById('tableBody');
    let html = '';
    participants.forEach(participant => {
        html += `<tr>
            <td>${participant.id}</td>
            <td>${participant.name}</td>
            <td>${participant.points}</td>
        </tr>`
    })
    tableBody.innerHTML = html;
}