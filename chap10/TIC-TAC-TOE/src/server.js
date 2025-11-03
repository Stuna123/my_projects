const express = require('express')
const { v4: uuid } = require('uuid') 
const port = 8080

let games = []

const app = express()
app.use(express.json())

function getPairs(arr1, arr2) {
    return arr1.flatMap(letter => arr2.map(number => letter + number))
}

function generateTicTacToeMoves() {
    //['A', 'B', 'C'].flatMap(letter => ['1', '2', '3'].map(number => letter + number))
    return getPairs(['A', 'B', 'C'], ['1', '2', '3'])
}

app.post('/games', (req, res) => {
    const newGameId = uuid()
    const newGame = {
        id: newGameId,
        playerXMoves: [],
        playerOMoves: [],
        availableMoves: generateTicTacToeMoves()
    }
    games.push(newGame)
    res.send(`Welcome to Tic-Tac-Toe! Your game id is ${newGameId}`)
})

function getGameById(id) {
    return games.find(game => game.id === id)
}

function isHorinzontalWin(playerMoves) {
    return ['1', '2', '3'].some(number => playerMoves.filter(move => move.includes(number)).length >= 3)
}

function isVerticalWin(playerMoves) {
    return ['A', 'B', 'C'].some(number => playerMoves.filter(move => move.includes(number)).length >= 3)
}

function isDiagonalWin(playerMoves) {
    return ['A1', 'B2', 'C3'].every(move => playerMoves.includes(move))
        || ['A3', 'B2', 'C1'].every(move => playerMoves.includes(move))
}

function isCornersWin(playerMoves) {
    return ['A1', 'C1', 'A3', 'C3'].every(move => playerMoves.includes(move))
}

function isWin(playerMoves) {
    return isHorinzontalWin(playerMoves)
        || isVerticalWin(playerMoves)
        || isDiagonalWin(playerMoves)
        || isCornersWin(playerMoves)
}

app.post('/games/:gameId', (req, res) => {
    const { gameId } = req.params
    const { move }  = req.body

    const game = getGameById(gameId)

    // If the move is not a valide move
    if(!game.availableMoves.includes(move))
        return res.send(`${move} is not a valid move`)

    game.playerXMoves.push(move)
    game.availableMoves = game.availableMoves.filter(m => m !== move) 

    if(isWin(game.playerXMoves)) {
        return res.send('We have a winner. You win, congratulation :) !')
    } 

    if(game.availableMoves.length === 0) {
        return res.send('The game is over! Nobody wins')
    }

    const serverMove = game.availableMoves[Math.floor(Math.random() * game.availableMoves.length)]
    game.playerOMoves.push(serverMove)
    game.availableMoves = game.availableMoves.filter(m => m!== serverMove)

    if(isWin(game.playerOMoves)) {
        return res.send('The winner has been decided. You lose, game over! Try your best next time ☺☻')
    }

    res.json(game)
})

app.listen(port, () => console.log(`Server is listening on port ${port}`))