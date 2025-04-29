<style>
    body {
        font-family: Arial, sans-serif;

    }
    
    .message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateX(100%);
        transition: opacity 0.5s, transform 0.5s;
    }

    .error-message {
        background-color: #ff4d4d;
        color: white;
    }
    .success-message {
        background-color: #4CAF50;
        color: white;
    }
    .message.show {
        opacity: 1;
        transform: translateX(0);
        z-index: 111111111;

    }
</style>

<div id="messageError" class="message error-message"></div>
<div id="messageSuccess" class="message success-message"></div>

<script>
    
    function showMessage(type, message) {
        const messageDiv = document.getElementById(type);
        document.getElementById(type).innerHTML = message;
        messageDiv.classList.add('show');
        
        setTimeout(() => {
            messageDiv.classList.remove('show');
        }, 4000);
    }

</script>

