const express = require('express')
const { engine } = require('express-handlebars')
const { escapeExpression } = require('handlebars')
const path = require('path')
const port = 8080

let todos = [{
    id:'123',
    text: 'Go to the grocery store',
    isCompleted: false
}, {
    id:'234',
    text: `" }]\`); alert('Hacked!'); function f(){}(\``,
    isCompleted: false
}]

const app = express()
app.use(express.json())

app.engine('hbs', engine())
app.set('view engine', 'hbs')
app.set('views', path.join(__dirname, 'views'))

app.get('/', (req, res) => {
    const safeTodos = todos.map(t => ({
        ...t,
        text: escapeExpression(t.text), // we make sure the text won't contain anything dangerous
    }))
    res.render('index', { todos, todosString: JSON.stringify(safeTodos), layout: false })
})

app.listen(port, () => console.log(`Server is listening on port ${port}`))