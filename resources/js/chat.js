function StartChat(id) {
    document.getElementById('chatPanel').removeAttribute('style');
    document.getElementById('divStart').setAttribute('style', 'display: none');
}
function sendMessage(){
    var val = document.getElementById('textMessage').value;
    document.getElementById('textMessage').value = '';
    document.getElementById('textMessage').focus();
    document.getElementById('messages').scrollTo(0, document.getElementById('messages').clientHeight);
}