const express = require("express");
const sqlite = require("promised.sqlite");
const { User } = require("./user");
const book = require("./book");
const token = require("./token");
const user = require("./user");

(async () => {
    const app = express();
    app.use(require("body-parser").json());

    const db = await sqlite.open("app.db");

    if (db) {
        console.log("База SQLite данных подключена: %s", db.db.filename);
    } else {
        console.log("Ошибка подключения БД");
    }

    db.run("CREATE TABLE IF NOT EXISTS user (login varchar(32) not null, name varchar(32) not null, info varchar(255), pwdcrc INT not null)");
    db.run("CREATE TABLE IF NOT EXISTS token (id_user varchar(32) not null, value varchar(32) not null unique, expiration BIGINT not null)");
    db.run("CREATE TABLE IF NOT EXISTS book (author varchar(64) not null, name varchar(64) not null, url varchar(255) not null)");

    let server = app.listen(process.env.PORT || 4096, () => {
        console.log("Приложение запущенно на порту", server.address().port);
    });

    token.setDB(db);
    book.setDB(db);
    user.setDB(db);

    app.get("/api/book", book.getAll);
    app.post("/api/book", book.add);

    app.get("/api/book/:id", book.get);
    app.put("/api/book/:id", book.edit);
    app.delete("/api/book/:id", book.delete);

    app.get("/api/token", token.check);
    app.post("/api/token", token.login);
    app.put("/api/token", token.update);
    app.delete("/api/token", token.logout);

    app.get("/api/user", user.get);
    app.post("/api/user", user.register);
    app.put("/api/user", user.edit);

    app.post("/api/shutdown", async (req, res) => {
        let usr = await user.get(req);
        if (usr && usr['login'] == 'admin') {
            res.send('Goodbye!');
            server.close();
        } else {
            res.sendStatus(403);
        }
    })
})();