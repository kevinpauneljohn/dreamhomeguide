const messageField = document.getElementById('message');
const messageCount = document.getElementById('messageCount');
const maxLength = messageField.getAttribute('maxlength');

const updateMessageCount = () => {
    messageCount.textContent = messageField.value.length;
};

// Initial count
updateMessageCount();

// Listen to typing
messageField.addEventListener('input', updateMessageCount);
