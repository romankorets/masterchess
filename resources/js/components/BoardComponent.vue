<template>
    <div class="container" >
        <chessboard ref="chessboard" @onMove="handleMove" :fen="currentMove" />
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
                secondPlayerId: 0,
                secondPlayerColor: '',
                started: false,
                finished: false,
            }
        },
        computed:{
            lastMove: function () {
                return this.localMoves[this.localMoves.length - 1]['move'];
            }
        },
        methods:{
            handleMove(data){
                this.positionInfo = data;
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

                console.log('localMoves = ');
                console.log(this.localMoves);
                if (!(this.currentUserId === this.firstPlayerId) && !(this.currentUserId === this.secondPlayerId)){
                    this.$refs.chessboard.board.state.draggable.enabled = false;
                    this.$refs.chessboard.board.state.selectable.enabled = false;
                }

                console.log('Current userId = ' + this.currentUserId);
                console.log('MovesPHP = ' + this.movesPhp);
                console.log(data);
            }
        },
        mounted() {
            console.log('Component mounted.');
            console.log('gameId = ' + this.gameId);
            this.currentMove = this.lastMove;
        },
        created() {
            this.localMoves = JSON.parse(this.movesPhp);
            this.currentMove = this.localMoves[this.localMoves.length - 1]['move'];
        }
    }
</script>
