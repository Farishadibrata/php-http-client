const express = require('express')
const app = express()
const bodyParser = require('body-parser')
const jwt = require('jsonwebtoken')
const validCreds = {
  username: 'admin',
  password: 'admin111'
}
const privateKey = 'KEEEEEYYY'
app.use(bodyParser.urlencoded({ extended: true }))

app.get('/', (req, res) => {
  res.send('Success')
})

app.post('/login', (req, res) => {
  const { username, password } = req.body
  if (username === validCreds.username && password === validCreds.password) {
    res.status(200).json({ jwtkey: jwt.sign({ admin: '1' }, privateKey) })
  } else {
    res.status(200).json({ error: 'Invalid Creds' })
  }
})
app.post('/checkJWT', (req, res) => {
  if (req.headers['token']) {
    jwt.verify(req.headers['token'], privateKey, (err, decoded) => {
      if (err) res.status(503).json()
      else if (decoded) {
        res.status(200).json({ status: 'Success' })
      }
    })
  } else {
    res.status(503).json({ error: 'Unauthorized' })
  }
  // if(req.headers)
})
app.listen(3000, () => {
  console.log(`Listening on 3000`)
})
