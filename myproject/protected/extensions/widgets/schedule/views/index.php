
<table class="stat-table matches-table">
<tr data-match-id="976063">
    <td style="padding-right: 0;" class="alLeft gray-text">14:30</td>
    <!--<td class="alLeft gray-text">Завершен</td>-->
    <td class="owner-td">
        <div class="rel"><a class="player" href="#" title="Ривер Плейт">Ривер Плейт</a></div>
    </td>
    <td class="score-td score-popover" data-control="Common.Score" data-id="976063"><a class="score" href="#">

            <b><span class="s-left">1</span> : <span class="s-right">1</span></b>
        </a>
    </td>
    <td class="guests-td">
        <div class="rel"><a class="player" href="#" title="Олимпо">Олимпо</a></div>
    </td>
    <!--<td class="alRight"><div class="match-service-icons" data-video-type="video"><i id="tvbutton_976063" class="ico camera" title="Все видео"></i><i id="mytvbutton_976063" class="ico change-ico" title="Мой выбор"></i></div>
    </td>-->
</tr>
    <tr data-match-id="976063">
        <td style="padding-right: 0;" class="alLeft gray-text">14:30</td>
        <!--<td class="alLeft gray-text">Завершен</td>-->
        <td class="owner-td">
            <div class="rel"><a class="player" href="#" title="Ривер Плейт">Ривер Плейт</a></div>
        </td>
        <td class="score-td score-popover" data-control="Common.Score" data-id="976063"><a class="score" href="#">

                <b><span class="s-left">1</span> : <span class="s-right">1</span></b>
            </a>
        </td>
        <td class="guests-td">
            <div class="rel"><a class="player" href="#" title="Олимпо">Олимпо</a></div>
        </td>
        <!--<td class="alRight"><div class="match-service-icons" data-video-type="video"><i id="tvbutton_976063" class="ico camera" title="Все видео"></i><i id="mytvbutton_976063" class="ico change-ico" title="Мой выбор"></i></div>
        </td>-->
    </tr>

</table>


<style>
    .stat-table {
        font-size: 11px;
        width: 100%;
        text-align: center;
        table-layout: fixed;
    }
    .matches-table TD, .calend-table TD {
        background: #fff;
    }
    .matches-table TD:nth-of-type(-n+4) {
       /* border-top: 1px solid #d8d8d8;*/
    }

    .stat-table TD, .stat-table THEAD .score-td {
        background: #f9f9f7;
        /*border-top: 1px solid #d8d8d8;*/
        border-bottom: 1px solid #d8d8d8;
        vertical-align: middle;
        line-height: 15px;
    }
    .stat-table TD {
        white-space: nowrap;
    }
    .alLeft {
        text-align: left !important;
    }
    .gray-text {
        color: #7f7f7f !important;
    }
    .stat-table .owner-td {
        padding-right: 5px;
        text-align: right;
        white-space: nowrap;
    }
    .stat-table .owner-td > .rel {
        float: right;
    }
    .rel {
        position: relative;
    }
    .stat-table .owner-td .rel > .fader {
        right: 16px;
        top: 2px;
        width: 9px;
        background-position: 1px 0;
        z-index: 5;
    }
    .matches-table .fader, .calend-table .fader {
        background-image: url(http://s5o.ru/common/css/i/fader-wht.png);
    }
    .fader {
        display: block;
        position: absolute;
        top: 0;
        right: -5px;
        background: url(http://s5o.ru/common/css/i/fader.png) repeat-y 0 0;
        width: 14px;
        height: 22px;
    }
    .stat-table.matches-table .player {
        max-width: 98px;
    }
    .stat-table .owner-td .player, .stat-table .owner-td .flag-s, .stat-table .owner-td .player-score {
        float: right;
    }
    .stat-table .player {
        overflow: hidden;
        position: relative;
        display: inline-block;
        vertical-align: top;
        white-space: nowrap;
        max-width: 125px;
        /*padding: 0 5px;*/
    }
    .stat-table .score {
        display: inline-block;
        vertical-align: top;
    }
    .stat-table A {
        text-decoration: none;
    }
    .stat-table .score-td {
        width: 30px;
        background: #e8e8e0;
    }
    .stat-table .score .s-left {
        text-align: right;
    }
    .stat-table .score .s-left, .stat-table .score .s-right {
        width: 13px;
        display: inline-block;
    }
    .stat-table .score .s-right {
        text-align: left;
    }
    .stat-table .guests-td {
        padding-left: 5px;
        text-align: left;
        white-space: nowrap;
    }
    .mainPart .stat-table .guests-td > .rel {
        overflow: hidden;
    }
    .stat-table .guests-td > .rel {
        float: left;
    }
    .stat-table .guests-td .rel > .fader {
        right: -2px;
        top: 2px;
        width: 9px;
        z-index: 5;
    }
    .alRight {
        text-align: right !important;
    }


    /*http://s5o.ru/common/css/i/icons.png*/
</style>