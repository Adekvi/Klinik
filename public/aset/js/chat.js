// Get elements
const chatBox = document.getElementById('chat-box');
const chatIcon = document.getElementById('chat-icon');
const closeBtn = document.getElementById('close-chat');
const chatContent = document.getElementById('chat-content');
const chatForm = document.getElementById('chat-form');
const messageInput = document.getElementById('message');
const receiverIdInput = document.getElementById('receiver-id');

// Default message to show when no messages are there
const defaultMessage =
    `<div class="message admin"><strong>Admin</strong><p>Apakah ada yang bisa dibantu?</p></div>`;

// Show chat box and hide icon
function openChat() {
    chatBox.style.display = 'flex';
    chatIcon.style.display = 'none'; // Hide customer image when chat is open
    fetchMessages(receiverIdInput.value); // Fetch messages when opening the chat
}

// Close chat box and show icon
function closeChat() {
    chatBox.style.display = 'none';
    chatIcon.style.display = 'block'; // Show customer image when chat is closed
}

// Event listener for close button
closeBtn.addEventListener('click', closeChat);

// Event listener for customer image (icon)
chatIcon.addEventListener('click', openChat);

// Function to fetch messages
function fetchMessages(receiverId) {
    fetch(`/chat/fetchMessages/${receiverId}`)
        .then(response => response.json())
        .then(messages => {
            chatContent.innerHTML = ''; // Clear current messages

            if (messages.length === 0) {
                // Show default message if no messages exist
                chatContent.innerHTML = defaultMessage;
            } else {
                // Add messages
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('message');
                    messageDiv.classList.add(message.sender_id === receiverId ? 'admin' : 'user');
                    messageDiv.innerHTML =
                        `<strong>${message.sender_name}:</strong> ${message.message}`;
                    chatContent.appendChild(messageDiv);
                });
            }

            chatContent.scrollTop = chatContent.scrollHeight; // Scroll to the bottom
        });
}

// Event listener for the form submission
chatForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const message = messageInput.value;
    const receiverId = receiverIdInput.value;

    // Send the message to the server
    fetch('/chat/sendMessage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            },
            body: JSON.stringify({
                message: message,
                receiver_id: receiverId
            })
        })
        .then(response => response.json())
        .then(data => {
            // Add the sent message to chat
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message', 'user'); // Add user class
            messageDiv.innerHTML = `<strong>You:</strong> ${data.message}`;
            chatContent.appendChild(messageDiv);
            messageInput.value = ''; // Clear the input field
            chatContent.scrollTop = chatContent.scrollHeight; // Scroll to the bottom
        })
        .catch(error => console.log('Error sending message:', error));
});

// Initial state (if chat is closed on page load, show the icon)
chatIcon.style.display = 'block';
chatBox.style.display = 'none';