document.getElementById("send-btn").addEventListener("click", async () => {
    const userInput = document.getElementById("user-input").value;

    if (!userInput) return;

    const chatWindow = document.getElementById("chat-window");
    chatWindow.innerHTML += <p><strong>You:</strong> ${userInput}</p>;

    const response = await fetch('/api/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: userInput })
    });

    const data = await response.json();
    chatWindow.innerHTML += <p><strong>GPT:</strong> ${data.reply}</p>;
});