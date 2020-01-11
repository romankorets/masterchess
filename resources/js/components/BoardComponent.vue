<template>
    <div class="container">
        <div class="board">
            <div v-for="(figure, index) in lastMove" :id="'s' + index" class="square" :class="{black: isBlackSquareAt(index), white: !isBlackSquareAt(index)}" >
                <div class="figure"></div>
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
                    case 'K' : return '&#9812;';
                    case 'Q' : return '&#9813;';
                    case 'R' : return '&#9814;';
                    case 'B' : return '&#9815;';
                    case 'N' : return '&#9816;';
                    case 'P' : return '&#9817;';
                    case 'k' : return '&#9818;';
                    case 'q' : return '&#9819;';
                    case 'r' : return '&#9820;';
                    case 'b' : return '&#9821;';
                    case 'n' : return '&#9822;';
                    case 'p' : return '&#9823;';
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
            //console.log('moves ' + this.local_moves[0]['move']);
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
