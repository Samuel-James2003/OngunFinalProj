const app = require("express")();
const express = require("express");
const bodyParser = require('body-parser');
const server = require("http").createServer(app);
const io = require("socket.io")(server);
const portnum = 3000;

app.use(bodyParser.urlencoded({ extended: false }));

// Serve static files (e.g., HTML, CSS, JavaScript)
app.use(express.static(__dirname + '/public'));

// Login and Registration routes
app.post('/login.php', (req, res) => {
    // Handle the login request here
    const email = req.body.log_email;
    const password = req.body.log_password;
    console.log(email);
    // Authenticate the user, check the database, etc.
    // Respond with appropriate data or redirect
    res.send("Hi")
});

app.post('/register', (req, res) => {
    // Handle the registration request here
    const username = req.body.username;
    const password = req.body.password;

    // Validate and store user information in the database
    // Respond with appropriate data or redirect
});
//Creation du serveur sur localhost
app.use(express.static(__dirname + '/view'));

app.get("/", (req, res) => {
    res.sendFile(`${__dirname}/view/index.php`);

});

io.on("connection", (socket) => {
    console.log("Utilisateur s'est connecté");

    //On disconnect
    socket.on("disconnect", () => {
        console.log("Utilisateur s'est déconnecté");
    });

    //On message received
    socket.on("chat message", (msg) => {
        console.log("Message", msg);
        io.emit("chat message", msg);
    });
});

server.listen(portnum, () => {
    console.log(`http://localhost:${portnum}/`);
    console.log("serveur a l'ecoute");

});