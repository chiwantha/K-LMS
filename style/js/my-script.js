var studentregform = document.getElementById('form--wrapper');

function hideShowStudentReg() {
    studentregform.classList.toggle("hide");
}

var studenteditform = document.getElementById('form--wrapper--edit')

function hideShowStudentEdit() {
    studenteditform.classList.toggle("hide");
}

var tutorclasstoggle = document.getElementById('classForm');

function toggletutorclass() {
    tutorclasstoggle.classList.toggle("d-none");
}

var tutorclassedittoggle = document.getElementById('tutorclasseditform');

function toggletutoreditclass() {
    tutorclassedittoggle.classList.toggle("d-none");
}

var tutorlessontoggle = document.getElementById('formContainer');

function toggletutorlesson() {
    tutorlessontoggle.classList.toggle("d-none");
}

var tutorlessonedittoggle = document.getElementById('tutorlessoneditform');

function toggletutoreditlesson() {
    tutorlessonedittoggle.classList.toggle("d-none");
}

var tutorbanktoggle = document.getElementById('bankForm');

function toggletutorbank() {
    tutorbanktoggle.classList.toggle("d-none");
}

var tutorbankedittoggle = document.getElementById('tutorbankeditform');

function toggletutoreditbank() {
    tutorbankedittoggle.classList.toggle("d-none");
}

var tutorpaymenttoggle = document.getElementById('tutorpaymentviewform');

function toggletutorpaymentreview() {
    tutorpaymenttoggle.classList.toggle("d-none");
}

var tutorpaymentrejecttoggle = document.getElementById('reject_payment_form');

function togglerejectpayment() {
    tutorpaymentrejecttoggle.classList.toggle("d-none");
}

var tutorbatchformtoggle = document.getElementById('batchForm');

function toggletutorbatch() {
    tutorbatchformtoggle.classList.toggle("d-none");
}

var tutoreditbatchformtoggle = document.getElementById('tutorbatcheditform');

function toggletutorbatchedit() {
    tutoreditbatchformtoggle.classList.toggle("d-none");
}

var tutormessagetoggle = document.getElementById('messageForm');

function toggletutormessage() {
    tutormessagetoggle.classList.toggle("d-none");
}

var tutortickettoggle = document.getElementById('ticketForm');

function toggletutorticket() {
    tutortickettoggle.classList.toggle("d-none");
}

var tutorialplayer = document.getElementById('tutorial_player');

function howtouse() {
    tutorialplayer.classList.toggle("d-none");
}


document.addEventListener('keyup', (e)=> {
    navigator.clipboard.writeText('');
    //alert('Screenshots and recodes are disabled !')
})
