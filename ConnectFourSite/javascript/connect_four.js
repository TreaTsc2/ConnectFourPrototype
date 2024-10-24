const board = [];
const rows = 6;
const cols = 7;
const winningLength = 4;

function createBoard() {
    for (let i = 0; i < rows; i++) {
        board.push(Array(cols).fill(0));
    }
}

function printBoard() {
    console.clear();
    for (let row = 0; row < rows; row++) {
        let rowStr = "";
        for (let col = 0; col < cols; col++) {
            rowStr += board[row][col] === 0 ? " | " : `${board[row][col]} | `;
        }
        console.log(rowStr);
    }
}

function dropPiece(col, player) {
    for (let row = rows - 1; row >= 0; row--) {
        if (board[row][col] === 0) {
            board[row][col] = player;
            return true;
        }
    }
    return false;
}

function checkWinner(player) {
    // Check horizontal
    for (let row = 0; row < rows; row++) {
        for (let col = 0; col < cols - winningLength + 1; col++) {
            if (board[row][col] === player &&
                board[row][col + 1] === player &&
                board[row][col + 2] === player &&
                board[row][col + 3] === player) {
                return true;
            }
        }
    }

    // Check vertical
    for (let row = 0; row  
 < rows - winningLength + 1; row++) {
        for (let col = 0; col < cols; col++) {
            if (board[row][col] === player &&
                board[row + 1][col] === player &&
                board[row + 2][col] === player &&
                board[row + 3][col] === player) {
                return true;
            }
        }
    }

    // Check diagonal (top-left to bottom-right)
    for (let row = 0; row < rows  
 - winningLength + 1; row++) {
        for (let col = 0; col < cols - winningLength + 1; col++) {
            if (board[row][col] === player &&
                board[row + 1][col + 1] === player &&
                board[row + 2][col + 2] === player &&
                board[row + 3][col + 3] === player) {
                return true;
            }
        }
    }

    // Check  
 diagonal (top-right to bottom-left)
    for  
 (let row = 0; row < rows - winningLength + 1; row++) {
        for (let col = winningLength - 1; col < cols; col++) {
            if (board[row][col] === player &&
                board[row + 1][col - 1] === player &&
                board[row + 2][col - 2] === player &&
                board[row + 3][col - 3] === player) {
                return true;
            }
        }
    }

    return false;  

}

function playGame() {
    createBoard();
    printBoard();

    let currentPlayer = 1;
    while (true) {
        const col = parseInt(prompt(`Player ${currentPlayer}, enter a column (1-${cols}):`));
        if (isNaN(col) || col < 1 || col > cols) {
            console.log("Invalid column. Please try again.");
            continue;
        }

        if (dropPiece(col - 1, currentPlayer)) {
            printBoard();
            if (checkWinner(currentPlayer)) {
                console.log(`Player ${currentPlayer} wins!`);
                break;
            }
            currentPlayer = currentPlayer === 1 ? 2 : 1;
        } else {
            console.log("Column is full. Please choose another.");
        }
    }
}

playGame();