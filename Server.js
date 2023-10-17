const app = require("express")();
const express = require("express");
const server = require("http").createServer(app);
const io = require("socket.io")(server);
const portnum = 3000;

//Creation du serveur sur localhost
app.use(express.static(__dirname + '/images'));

app.get("/", (req, res) => {
    res.sendFile(`${__dirname}/index.html`);
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