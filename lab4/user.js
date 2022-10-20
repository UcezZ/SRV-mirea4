const token = require('./token');
const crc32 = require("crc-32");

class User {
    static #db;

    static setDB(db) {
        User.#db = db;
    }

    static async get(req, res = undefined) {
        if (!res && req && req.body.token) {
            let row = await token.check(req.body.token);
            return row ? await User.#db.get('SELECT ROWID as id, login, name, info FROM user WHERE ROWID = ?', [row['id_user']]) : undefined;
        } else if (res) {
            if (req && req.body.token) {
                let row = await User.get(req);
                if (row) {
                    res.send(row);
                    console.log('got user %s assigned to token %s', row['name'], req.body.token);
                    return;
                }
            }
            res.sendStatus(401);
        }
        /*
                if (!res && typeof (req) == 'string') {
                    let row = await token.check(req);
                    return row ? await User.#db.get('SELECT ROWID as id, login, name, info FROM user WHERE ROWID = ?', [row['id_user']]) : undefined;
                }
                else if (res) {
                    if (req.body.token) {
                        let row = await User.get(req);
                        if (row) {
                            res.send(row);
                            console.log('got user #%s assigned to token #%d', row['name'], req.body.token);
        
                        } else {
                            res.sendStatus(401);
                        }
                    } else if (req.body.token) {
                        return await User.get(req.body.token);
                    }
                }
        */
    }

    static async register(req, res) {
        if (await User.get(req)) {
            req.status(400).send({ error: 'User authorized' });
        } else {
            if (req.body.login && req.body.login.length && req.body.password && req.body.password.length && req.body.name && req.body.name.length) {
                let row = await User.#db.get('SELECT count(*) as cnt FROM user WHERE login = ?', [req.body.login]);
                if (row['cnt']) {
                    res.status(403).send({ error: 'Username already registered' });
                } else {
                    let pwdcrc = crc32.str(req.body.password);
                    await User.#db.run('INSERT INTO user (login, pwdcrc, name, info) values (?, ?, ?, ?)',
                        [req.body.login, pwdcrc, req.body.name, req.body.info ?? '']);
                    res.sendStatus(200);
                    console.log('Registered user %s', req.body.login);
                }
            } else {
                res.status(400).send({ error: 'Bad login/name/password' });
            }
        }
    }

    static async edit(req, res) {
        let user = await User.get(req);
        if (user) {
            if (req.body.name || req.body.info) {
                await User.#db.run('UPDATE user SET name = ?, info = ? WHERE ROWID = ?',
                    [req.body.name ?? user['name'], req.body.info ?? user['info'], user['id']]);
                res.sendStatus(200);
            } else {
                res.status(400).send({ error: 'Bad name/info' });
            }
        } else {
            res.sendStatus(401);
        }
    }
}

module.exports = User;