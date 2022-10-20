const user = require('./user');

class Book {
    static #db;

    static setDB(db) {
        Book.#db = db;
    }

    static async getAll(req, res) {
        console.log("[BOOK] GET");

        if (await user.get(req)) {
            res.json(await Book.#db.all("SELECT ROWID as id, * FROM book"));
        }
        else {
            res.sendStatus(401);
        }
    }

    static async add(req, res) {
        console.log("[BOOK] POST");
        let usr = await user.get(req);
        if (usr && usr['login'] == 'admin') {
            if (req.body.author && req.body.name) {
                let result = await Book.#db.run("INSERT INTO book (author, name, url) VALUES (?, ?, ?)",
                    [req.body.author, req.body.name, req.body.url ?? '']);
                console.log(result);
                res.sendStatus(200);
            }
            else {
                res.status(400).send({ error: 'Parameter unspecified' });
            }
        } else {
            res.sendStatus(403);
        }
    }


    static async get(req, res) {
        if (await user.get(req)) {
            if (!res && req) {
                console.log("[BOOK] GET %s", req.params.id);
                return await Book.#db.get("SELECT ROWID as id, * FROM book WHERE ROWID = ?", [req.params.id]);
            } else {
                let row = await Book.get(req);
                if (row) {
                    console.log(row);
                    res.send(row);
                } else {
                    res.sendStatus(404);
                }
            }
        } else {
            res.sendStatus(403);
        }
    }

    static async edit(req, res) {
        console.log("[BOOK] PUT %s", req.params.id);

        let usr = await user.get(req);
        if (usr && usr['login'] == 'admin') {
            let book = await Book.get(req);
            if (book && ('author' in req.body || 'name' in req.body || 'url' in req.body)) {
                await Book.#db.run('UPDATE book SET author = ?, name = ?, url = ? WHERE ROWID = ?',
                    [req.body.author ?? book['author'], req.body.name ?? book['name'], req.body.url ?? book['url'], req.params.id]);
                console.log('edited book #%d');
                res.sendStatus(200);
            } else {
                res.status(400).send({ error: 'Bad id/author/name' });
            }
        } else {
            res.sendStatus(403);
        }
    }

    static async delete(req, res) {
        console.log("[BOOK] DELETE %s", req.params.id);
        let usr = await user.get(req);
        if (usr && usr['login'] == 'admin') {
            let book = await Book.get(req);
            if (book) {
                await Book.#db.run("DELETE FROM book WHERE ROWID = ?",
                    [req.params.id]);
                console.log('deleted book %s', req.params.id);
                res.sendStatus(200);
            } else {
                res.sendStatus(404);
            }

        } else {
            res.sendStatus(403);
        }
    }
}

module.exports = Book;
