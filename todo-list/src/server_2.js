const express = require('express')
const { engine } = require('express-handlebars')
const { escapeExpression } = require('handlebars')
const { v4: uuid } = require('uuid')
const path = require('path')
const port = 8080

let todos = [{
    id:'123',
    text: 'Go to the grocery store',
    isCompleted: false
}, {
    id:'234',
    text: 'Do 100 push-ups',
    isCompleted: false
}]

const app = express()
app.use(express.json())

app.engine('hbs', engine())
app.set('view engine', 'hbs')
app.set('views', path.join(__dirname, 'views'))

// endpoint
app.get('/', (req, res) => {
    const safeTodos = todos.map(t => ({
        ...t,
        text: escapeExpression(t.text), // we make sure the text won't contain anything dangerous
    }))
    res.render('index_2', { todos, todosString: JSON.stringify(safeTodos), layout: false })
})

// add
app.post('/todos', (req, res) => {
    const { newTodoText } = req.body
     const newTodo = {
        id: uuid(),
        text: escapeExpression(newTodoText),
        isCompleted: false
    }
    todos.push(newTodo)
    res.json(newTodo)
})

// update
app.put('/todos/:id', (req, res) => {
    const { id }        = req.params
    const todo          = todos.find(t => t.id === id)
    todo.isCompleted    = true
    res.json(todo)
})

// delete
app.delete('/todos/:id', (req, res) => {
    const { id } = req.params;
    const todoIndex = todos.findIndex(t => t.id === id);

    if (todoIndex === -1) {
        return res.status(404).json({ error: "Todo not found" });
    }

    todos.splice(todoIndex, 1);
    res.status(204).send();
});


app.listen(port, () => console.log(`Server is listening on port ${port}`))