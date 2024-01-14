const app = require("express")();
const express = require("express");
const server = require("http").createServer(app);
const io = require("socket.io")(server);


app.use(express.static(__dirname + '/images'));

app.get("/", (req, res) => {
    res.sendFile(`${__dirname}/index.html`);
});

io.on("connection", (socket) => {
    console.log("Utilisateur s'est connecté");


    socket.on("disconnect", () => {
        console.log("Utilisateur s'est déconnecté");
    });

    socket.on("chat message", (msg) => {
        console.log("Message", msg);
        io.emit("chat message", msg);
    });
});

server.listen(3000, () => {
    console.log("http://localhost:3000/");
    console.log("serveur a l'ecoute");

});
