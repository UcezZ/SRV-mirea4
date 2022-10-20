const uuid = require("uuid");
const crc32 = require("crc-32");

class Token {
    static #db;

    static setDB(db) {
        Token.#db = db;
    }

    static async check(req, res = undefined) {
        if (!res && typeof (req) == 'string') {
            return await Token.#db.get("SELECT ROWID as id, id_user, expiration as expires, strftime('%Y-%m-%d %H:%M:%S MSK', datetime(expiration / 1000 + 10800, 'unixepoch')) as expires_humanreadable FROM token WHERE value = ? and expiration > ?", [req, new Date().getTime()]);
        } else if (req.body.token) {
            let row = await Token.check(req.body.token);
            if (row) {
                res.send(row);
                console.log('got token #%d assigned to user #%s', row['id'], row['id_user']);
                console.log()
            } else {
                res.sendStatus(404);
            }
        } else {
            res.sendStatus(400);
        }
    }

    static async login(req, res) {
        if (req.body.login && req.body.password) {
            let pwdcrc = crc32.str(req.body.password);
            let row = await Token.#db.get("SELECT ROWID as id FROM user WHERE login = ? and pwdcrc = ?",
                [req.body.login, pwdcrc]);
            if (row && row['id']) {
                let ts = new Date().getTime() + 3600000;
                let token = uuid.v1();
                while (token.includes('-')) {
                    token = token.replace('-', '');
                }
                await Token.#db.run("INSERT INTO token (id_user, value, expiration) VALUES (?, ?, ?)", [row['id'], token, ts]);
                //res.cookie('token', token, { maxage: 3600000 });
                res.status(200).send({ "token": token });
            } else {
                res.status(401).send({ error: 'Bad login/password' });
            }
        } else {
            res.status(400).send({ error: 'Parameter unspecified' });
        }
    }

    static async update(req, res) {
        if (req.body.token) {
            let row = await Token.check(req.body.token);
            if (row) {
                let ts = new Date().getTime() + 3600000;
                await Token.#db.run("UPDATE token SET expiration = ? where ROWID = ?", [ts, row['id']]);
                res.sendStatus(200);
                return;
            }
        }
        res.sendStatus(401);
    }

    static async logout(req, res) {
        if (req.body.token) {
            let row = await Token.check(req.body.token);
            if (row) {
                await Token.#db.run("UPDATE token SET expiration = ? where ROWID = ?", [new Date().getTime(), row['id']]);
                res.sendStatus(200);
                return;
            }
        }
        res.sendStatus(401);
    }
}

module.exports = Token;
