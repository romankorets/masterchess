<template>
    <chessboard ref="chessboard" @onMove="handleMove" :fen="currentMove" :orientation="orientation"/>
</template>

<script>

    import {chessboard} from 'vue-chessboard'
    import 'vue-chessboard/dist/vue-chessboard.css'
    export default {
        components: {
            chessboard
        },

        props: [
            'gameIdPhp', 'movesPhp', 'currentUserIdPhp', 'firstPlayerIdPhp', 'firstPlayerColorPhp'
        ],
        data: function(){
            return {
                currentUserId: this.currentUserIdPhp,
                currentMove: '',
                positionInfo: null,
                gameId: this.gameIdPhp,
                firstPlayerId: this.firstPlayerIdPhp,
                firstPlayerColor: this.firstPlayerColorPhp,
                localMoves: JSON.parse(this.movesPhp),
                secondPlayerId: 0,
                secondPlayerColor: '',
                started: false,
                finished: false,
                orientation: 'white',
                timer : null,
                delay : 500
            }
        },
        watch: {
            secondPlayerId: function(newPlayer){
                if (this.secondPlayerId != 0){
                    this.started = true;
                }
            },
            positionInfo: function (newPositionInfo){
                if(this.checkIfCurrentUserHasTurn(newPositionInfo.turn)){
                    this.enableBoard();
                } else this.disableBoard();
            },
        },
        computed:{
            lastMove: function () {
                return this.localMoves[this.localMoves.length - 1]['move'];
            },
            isPositionRefresh: function () {
                return this.checkIfCurrentUserHasTurn(this.positionInfo.turn);
            },
        },

        methods:{
            handleMove(data){
                if (this.checkIfCurrentUserIsPlayer()){
                    this.enableBoard();
                }
                this.positionInfo = data;

                console.log('History ');
                console.log(this.$refs.chessboard.game.history());
                this.currentMove = this.positionInfo.fen;
                if(this.positionInfo.fen !== this.lastMove){
                    this.localMoves.push({
                        id : this.localMoves.length,
                        move : this.positionInfo.fen
                    });
                    axios.put('/game/' + this.gameId,{
                        'moves': this.localMoves,
                        'started': this.started,
                        'finished': this.finished
                    }).then((response => {
                        console.log(response.data)
                    }));
                }
                // console.log('localMoves = ');
                // console.log(this.localMoves);
                // console.log('Current userId = ' + this.currentUserId);
                // console.log('started = ' + this.started);
                // console.log('First player id = ' + this.firstPlayerId);
                // console.log('Second player id = ' + this.secondPlayerId);
                // console.log('First player color = ' + this.firstPlayerColor);
                // console.log('Second player color = ' + this.secondPlayerColor);
                // console.log('MovesPHP = ' + this.movesPhp);
                // console.log('Data = ');
                // console.log(data);
                // console.log('Turn = ' + this.positionInfo.turn);
                // console.log('Is current player has turn = ' + this.checkIfCurrentUserHasTurn(this.positionInfo.turn));
            },

            getCurrentUserColor(){
                if(this.currentUserId == this.firstPlayerId){
                    return this.firstPlayerColor;
                } else if(this.currentUserId == this.secondPlayerId){
                    return this.secondPlayerColor;
                } else return 'white';
            },

            updateData(){
                if (!this.isPositionRefresh) {
                    axios.get('/get-game/' + this.gameId).then(response => {
                            this.secondPlayerId = response.data.secondPlayerId;
                            if (this.localMoves.length === response.data.moves.length) {
                                console.log('Position has no changes');
                            } else {
                                console.log(this.localMoves);
                                console.log(response.data.moves);
                                this.localMoves = response.data.moves;
                                this.currentMove = this.lastMove;
                            }
                        }
                    )
                }
            },

            checkIfGameOver(){
                return this.$refs.chessboard.game.game_over();
            },
            disableBoard(){
                this.$refs.chessboard.board.state.draggable.enabled = false;
                this.$refs.chessboard.board.state.selectable.enabled = false;
            },

            enableBoard(){
                this.$refs.chessboard.board.state.draggable.enabled = true;
                this.$refs.chessboard.board.state.selectable.enabled = true;
            },

            checkIfCurrentUserIsPlayer(){
                return (this.currentUserId == this.firstPlayerId) || (this.currentUserId == this.secondPlayerId);
            },

            checkIfCurrentUserHasTurn(currentColorTurn){
                if(this.currentUserId == this.firstPlayerId){
                    return this.firstPlayerColor == currentColorTurn;
                } else if (this.currentUserId == this.secondPlayerId){
                    return this.secondPlayerColor == currentColorTurn;
                } else return false;
            },

            setRightOrientationByPlayerId(PlayerId){
                if(PlayerId == this.firstPlayerId){
                    if (this.firstPlayerColor == 'black' && 'white' == this.getBoardOrientation()){
                        this.flipBoard();
                        this.orientation = 'black';
                    } else this.orientation = 'white';
                } else if(PlayerId == this.secondPlayerId){
                    if(this.secondPlayerColor == 'black' && 'white' == this.getBoardOrientation()){
                        this.flipBoard();
                        this.orientation = 'black';
                    } else this.orientation = 'white';
                }
            },
            getBoardOrientation(){
                return this.$refs.chessboard.board.state.orientation;
            },

            flipBoard(){
                this.$refs.chessboard.board.toggleOrientation();
            },

            setColorToSecondPlayer(){
                if(this.firstPlayerColor == 'white'){
                    this.secondPlayerColor = 'black';
                } else this.secondPlayerColor = 'white';
            },
            setSecondPlayer(){
                if(this.currentUserId != this.firstPlayerId && this.secondPlayerId == 0){
                    this.secondPlayerId = this.currentUserId;
                }
                if (this.secondPlayerId != 0){
                    axios.put('/game/' + this.gameId,{
                        'second_player_id': this.secondPlayerId,
                    }).then((response => {
                        console.log(response.data)
                    }));
                }
            },
            tryToStartGame(){
                if (this.secondPlayerId != 0){
                    this.started = true;
                }
                if(this.started == true){
                    axios.put('/game/' + this.gameId,{
                        'started': this.started,
                    }).then((response => {
                        console.log(response.data)
                    }));
                }
            },
            getCurrentTurnColor(){
               return this.$refs.chessboard.board.state.turnColor;
            }
        },
        mounted() {
            console.log('Component mounted.');
            console.log('gameId = ' + this.gameId);
            console.log('Chessboard = ');
            console.log(this.$refs.chessboard);
            this.setRightOrientationByPlayerId(this.currentUserId);
            if (this.checkIfCurrentUserHasTurn(this.getCurrentTurnColor())){
                this.enableBoard();
            } else this.disableBoard();
            this.timer = setInterval(this.updateData, this.delay);


            //console.log('game over ' + this.$refs.chessboard.game.in_checkmate());
        },
        created() {
            this.setSecondPlayer();
            this.tryToStartGame();
            // defining last position to the board
            this.localMoves = JSON.parse(this.movesPhp);
            this.currentMove = this.localMoves[this.localMoves.length - 1]['move'];
            // defining color to second player
            this.setColorToSecondPlayer();
        }
    }
</script>
