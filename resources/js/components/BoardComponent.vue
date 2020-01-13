<template>
    <div class="container">
        <chessboard @onMove="showInfo" :fen="currentMove"/>
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
            'gameId', 'moves'
        ],
        data: function(){
            return {
                currentMove: '',
                positionInfo: null,
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
        methods:{
            showInfo(data){
                this.positionInfo = data;
                console.log(data);
            }
        },
        mounted() {
            console.log('Component mounted.');
            console.log('gameId ' + this.game_id);
            console.log();
        }
    }
</script>
