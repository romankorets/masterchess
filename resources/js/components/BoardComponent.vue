<template>
    <div class="container">
        <div class="board">
            <div v-for="(figure, index) in lastMove" :id="'s' + index" class="square" :class="{black: isBlackSquareAt(index), white: !isBlackSquareAt(index)}">
                <div :id = "'f' + figure" class="figure">{{getChessSymbol(figure)}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'gameId', 'moves'
        ],
        data: function(){
            return {
                game_id: this.gameId,
                first_player_id: 0,
                first_player_color: '',
                second_player_id: 0,
                second_player_color: '',
                local_moves: JSON.parse(this.moves),
                started: false,
                finished: false,
            }
        },
        computed:{
            lastMove: function(){
                let lastMove = this.local_moves[this.local_moves.length - 1]['move'];
                lastMove = lastMove.split("");
                lastMove.pop();
                lastMove.pop();
                return lastMove;
            }
        },
        methods:{
            getChessSymbol: function (figure) {
                switch (figure) {
                    case 'K' : return '♔';
                    case 'Q' : return '♕';
                    case 'R' : return '♖';
                    case 'B' : return '♗';
                    case 'N' : return '♘';
                    case 'P' : return '♙';
                    case 'k' : return '♚';
                    case 'q' : return '♛';
                    case 'r' : return '♜';
                    case 'b' : return '♝';
                    case 'n' : return '♞';
                    case 'p' : return '♟';
                    default  : return '';
                }
            },
            isBlackSquareAt: function (coord) {
                return (coord % 8 + Math.floor(coord / 8)) % 2;
            }
        },
        mounted() {
            console.log('Component mounted.');
            console.log('gameId ' + this.game_id);
            console.log('last move = ' + this.lastMove);
            console.log('moves ' + this.local_moves[0]['move']);
        }
    }
</script>

<style>
    .board {
        width: 660px;
        height: 660px;
        border: 10px solid #55cdef;
    }
    .square {
        float: left;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .black {
        background-color: #999;
    }
    .white {
        background-color: #eee;
    }
    .figure {
        font-size: 60px;
        cursor: pointer;
    }

</style>
