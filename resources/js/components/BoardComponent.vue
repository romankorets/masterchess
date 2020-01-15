<template>
    <div class="container" >
        <chessboard ref="chessboard" @onMove="handleMove" :fen="currentMove" :orientation="orientation" />
    </div>
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
                secondPlayerId: 4,
                secondPlayerColor: '',
                started: false,
                finished: false,
                orientation: 'white',
                isPositionRefresh: null
            }
        },
        watch: {
            positionInfo: function (newPositionInfo){
                if(this.checkIfCurrentUserHasTurn(newPositionInfo.turn )){
                    this.enableBoard();
                } else this.disableBoard();
            },
            isPositionRefresh: function (value) {
                if (value === false){
                    setTimeout(this.waitingForOpponentMove, 10000);
                }
            },
            turnColor: function(value){
                if (this.checkIfCurrentUserHasTurn(value)){
                    this.enableBoard();
                } else this.disableBoard();
            }
        },
        computed:{
            lastMove: function () {
                return this.localMoves[this.localMoves.length - 1]['move'];
            }
        },
        methods:{
            handleMove(data){
                if (this.checkIfCurrentUserIsPlayer()){
                    this.disableBoard();
                }
                this.positionInfo = data;
                this.isPositionRefresh = false;
                this.currentMove = this.positionInfo.fen;
                if(this.positionInfo.fen !== this.lastMove){
                    this.localMoves.push({
                        id : this.localMoves.length,
                        move : this.positionInfo.fen
                    });
                    axios.put('/game/' + this.gameId,{
                        'moves': this.localMoves
                    }).then((response => {
                        console.log(response.data)
                    }));

                }
                // while(!this.isPositionRefresh){
                //     setTimeout('this.waitingForOpponentMove()', 3000);
                // }
                //this.waitingForOpponentMove();
                console.log('localMoves = ');
                console.log(this.localMoves);
                console.log('Current userId = ' + this.currentUserId);
                console.log('First player id = ' + this.firstPlayerId);
                console.log('Second player id = ' + this.secondPlayerId);
                console.log('First player color = ' + this.firstPlayerColor);
                console.log('Second player color = ' + this.secondPlayerColor);
                console.log('MovesPHP = ' + this.movesPhp);
                console.log(data);
                console.log('Turn = ' + this.positionInfo.turn);
                console.log('Is current player has turn = ' + this.checkIfCurrentUserHasTurn(this.positionInfo.turn));
            },

            getCurrentUserColor(){
                switch (this.currentUserId) {
                    case this.firstPlayerId :
                        return this.firstPlayerColor;
                    case this.secondPlayerId :
                        return this.secondPlayerColor;
                    default:
                        return 'white';
                }
            },

            waitingForOpponentMove(){
                    axios.get('/get-game/' + this.gameId).then(response => {
                            this.secondPlayerId = response.data.secondPlayerId;
                            if (this.localMoves === response.data.moves) {
                                console.log(response.data);
                                this.isPositionRefresh = false;
                            } else {
                                console.log(response.data);
                                this.localMoves = response.data.moves;
                                this.isPositionRefresh = true;
                            }
                        }
                    )
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
                return (this.currentUserId !== this.firstPlayerId) && (this.currentUserId !== this.secondPlayerId);
            },

            checkIfCurrentUserHasTurn(currentColorTurn){
                switch (this.currentUserId) {
                    case this.firstPlayerId :
                        return this.firstPlayerColor === currentColorTurn;
                    case this.secondPlayerId :
                        return this.secondPlayerColor === currentColorTurn;
                    default:
                        return false;
                }
            },
            setRightOrientationByPlayerId(PlayerId){
                switch (PlayerId) {
                    case this.firstPlayerId :
                        if (this.firstPlayerColorPhp === 'white'){
                            this.orientation = 'white';
                        } else this.orientation = 'black';
                        break;
                    case this.secondPlayerId :
                        if(this.secondPlayerColor === 'white'){
                            this.orientation = 'white';
                        } else this.orientation = 'black';
                        break;
                    default :
                        this.orientation = 'white';
                }
            }

        },
        mounted() {
            console.log('Component mounted.');
            console.log('gameId = ' + this.gameId);
            console.log('Chessboard = ');
            console.log(this.$refs.chessboard);
            //this.currentMove = this.lastMove;

        },
        created() {
            // defining last position to the board
            this.localMoves = JSON.parse(this.movesPhp);
            this.currentMove = this.localMoves[this.localMoves.length - 1]['move'];
            // defining color to second player
            if(this.firstPlayerColor === 'white'){
                this.secondPlayerColor = 'black';
            } else this.secondPlayerColor = 'white';
            // setting right board orientation, white by default
            this.setRightOrientationByPlayerId(this.currentUserId);
            console.log('Orientation' + this.orientation);
        }
    }
</script>
