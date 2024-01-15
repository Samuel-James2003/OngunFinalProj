const app = require("express")();
const express = require("express");
const server = require("http").createServer(app);
const io = require("socket.io")(server);
const bodyParser = require('body-parser');
const cors = require('cors');
const mysql = require('mysql2');
const path = require('path');

app.use(cors());
app.use(express.static(__dirname + '/images'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
// Configure EJS as the view engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));
let ChatID;
const dbConfig = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'bdvacances',
};


app.post("/receiveData", (req, res) => {
    isAllowed = true;
    const data = req.body;
    console.log("Received data:", data);
    // userId = data.id;
    // personId = data.reciever;
    getOrCreateChat(data.id, data.reciever)
        .then((chatId) => {
            ChatID = chatId;
            console.log('Chat ID:', chatId);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    io.emit("receivedData", data);
    res.send("Data received successfully.");
});
app.get("/", (req, res) => {
    userId = 2;
    personId = 2;
    res.render("index", { userId: userId, personId: personId });
});


io.on("connection", (socket) => {
    console.log("Utilisateur s'est connecté");

    socket.on("disconnect", () => {
        console.log("Utilisateur s'est déconnecté");
    });

    socket.on("chat message", (msg) => {
        console.log(msg.PersonID);
        const newChatMessage = {
            ChatID: ChatID,
            PersonID: msg.PersonId,
            CMContent: msg.message,
            DateSent: msg.date
        };
        addChatMessageEntry(newChatMessage);
        console.log("Message", msg);
        io.emit("chat message", msg);
    });
});

server.listen(3000, () => {
    console.log("http://localhost:3000/");
    console.log("serveur a l'ecoute");
});

function executeQuery(sqlQuery, callback) {
    const connection = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'bdvacances',
    });

    connection.connect((err) => {
        if (err) {
            console.error('Error connecting to MySQL:', err);
            return callback(err, null);
        }

        console.log('Connected to MySQL');

        connection.query(sqlQuery, (error, results, fields) => {
            if (error) {
                console.error('Error executing query:', error);
                connection.end();
                return callback(error, null);
            }

            console.log('Query results:', results);
            connection.end((err) => {
                if (err) {
                    console.error('Error closing MySQL connection:', err);
                    return callback(err, null);
                }

                console.log('Connection to MySQL closed');
                callback(null, results);
            });
        });
    });
}
function addChatMessageEntry(newEntry) {
    // Create a MySQL connection
    const connection = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'bdvacances',
    });

    // SQL query to insert a new entry
    const sql = 'INSERT INTO t_chatmessage SET ?';

    // Execute the query
    connection.query(sql, newEntry, (err, result) => {
        if (err) throw err;
        console.log('New entry added to t_chatmessage table:', result);

        // Close the MySQL connection
        connection.end();
    });
}


function getOrCreateChat(senderId, receiverId) {
    const connection =  mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'bdvacances',
    });

    try {
        // Check if a chat link exists for the sender and receiver
        const [existingChat] = connection.execute(
            'SELECT c.ChatID FROM t_chatlink c1 JOIN t_chatlink c2 ON c1.ChatID = c2.ChatID WHERE c1.PersonID = ? AND c2.PersonID = ?',
            [senderId, receiverId]
        );

        if (existingChat.length > 0) {
            // If a chat link exists, return the ChatID
            return existingChat[0].ChatID;
        }

        // If no chat link exists, create a new chat
        const [result] =  connection.execute('INSERT INTO t_chat (DateCreated) VALUES (NOW())');
        const chatId = result.insertId;

        // Link the sender and receiver to the new chat
         connection.execute('INSERT INTO t_chatlink (ChatID, PersonID) VALUES (?, ?), (?, ?)', [
            chatId,
            senderId,
            chatId,
            receiverId,
        ]);

        return chatId;
    } finally {
        // Close the connection
        connection.end();
    }
}

