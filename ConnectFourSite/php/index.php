<?php 
session_start();
include '../html/header.html';
?>

<div class="connect-four-game container text-center">
    <div id="game"></div>
    <input type="number" id="moveInput" min="0" max="6" placeholder="Enter column (0-6)" class="form-control">
    <button onclick="makeMove()" class="btn btn-warning mt-2">Drop Disc</button>
    <p id="message"></p>
</div>

<script>
class ConnectFour {
    constructor() {
        this.rows = 6;
        this.columns = 7;
        this.board = Array.from({ length: this.rows }, () => Array(this.columns).fill(' '));
        this.currentPlayer = 'X';
        this.gameOver = false;
    }

    printBoard() {
        const boardHtml = this.board.map(row => '|' + row.join('|') + '|').join('<br>');
        document.getElementById('game').innerHTML = `
            <pre>${boardHtml}</pre>
            <p> 0  1  2  3  4  5  6 </p>
        `;
    }

    dropDisc(column) {
        if (this.gameOver) return;
        if (column < 0 || column >= this.columns || this.board[0][column] !== ' ') {
            document.getElementById('message').textContent = 'Invalid move. Try again.';
            return;
        }
        for (let row = this.rows - 1; row >= 0; row--) {
            if (this.board[row][column] === ' ') {
                this.board[row][column] = this.currentPlayer;
                if (this.checkWin(row, column)) {
                    this.printBoard();
                    document.getElementById('message').textContent = `Player ${this.currentPlayer} wins!`;
                    this.gameOver = true;
                    return;
                }
                this.currentPlayer = this.currentPlayer === 'X' ? 'O' : 'X';
                this.printBoard();
                document.getElementById('message').textContent = `Player ${this.currentPlayer}'s turn.`;
                return;
            }
        }
    }

    checkWin(row, column) {
        return (
            this.checkDirection(row, column, 1, 0) || // Horizontal
            this.checkDirection(row, column, 0, 1) || // Vertical
            this.checkDirection(row, column, 1, 1) || // Diagonal \
            this.checkDirection(row, column, 1, -1)   // Diagonal /
        );
    }

    checkDirection(row, column, rowStep, colStep) {
        let count = 0;
        for (let step = -3; step <= 3; step++) {
            const newRow = row + step * rowStep;
            const newCol = column + step * colStep;
            if (
                newRow >= 0 && newRow < this.rows &&
                newCol >= 0 && newCol < this.columns &&
                this.board[newRow][newCol] === this.currentPlayer
            ) {
                count++;
                if (count === 4) return true;
            } else {
                count = 0;
            }
        }
        return false;
    }
}

const game = new ConnectFour();
game.printBoard();
document.getElementById('message').textContent = `Player ${game.currentPlayer}'s turn.`;

function makeMove() {
    const column = parseInt(document.getElementById('moveInput').value);
    if (!isNaN(column)) {
        game.dropDisc(column);
    }
    document.getElementById('moveInput').value = '';
}
</script>

<?php
include '../html/footer.html';
?>