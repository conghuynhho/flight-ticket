<?php
/**
 * Created by Notepad.
 * User: Lak
 * Date: 12/10/13
 */
?>
    <h1 class="choisetitle"> &raquo; Lựa chọn chuyến bay &laquo;</h1>

    <form action="<?php echo _page("passenger")?>" method="post" id="frmSelectFlight">
        <div id="sinfo">
            <!--Thong Tin Chang Di-->
            <p class="location">
                <span class="fontplace"><?php echo  $GLOBALS['CODECITY'][$source] ?></span> đi <span class="fontplace"><?php echo  $GLOBALS['CODECITY'][$destination] ?></span>
            </p>
            <table class="info">
                <tr>
                    <td><span>Loại vé : </span><strong><?php echo  $direction_fulltext ?></strong></td>
                    <td><span>Số hành khách: </span> <strong><?php echo  $adults ?> người lớn<?php echo  $qty_children.$qty_infants ?></strong></td>
                </tr>
                <tr>
                    <td><span class="indate">Ngày xuất phát : <strong><?php echo  $depart_fulltext ?></strong></span></td>
                    <td>
                        <?php if($way_flight!=1){ ?>
                        <span class="indate">Ngày về : <strong><?php echo  $returndate_fulltext ?></strong></span>
                        <?php } ?>
                    </td>
                </tr>
            </table>

        </div>

        <!--SEARCH IN DIFFERENCE DAY-->
        <ul class="date-picker clear">
            <?php
            $arr_depDate = date_of_currentdate($depart_fulltext);
            $classli='class="firstli"';
            foreach($arr_depDate as $val)
            {
                ?>
                <li <?php if($classli!=""){ echo $classli; $classli=""; } ?> <?php if($val==$depart_fulltext) echo 'class="active"';?>>
                    <a rel="<?php echo  $val ?>" class="changedepartflight">
                        <span><?php echo  echoDate($val); ?></span>
                        <span style="font-weight:bold;"><?php echo  $val ?></span>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>

        <table class="flightlist" border="0" id="OutBound">
            <thead>
            <tr>
                <th style="padding-left:15px;text-align:left;width:150px;cursor: pointer;" class="type-string sortairport">Chuyến bay</th>
                <th width="130px" class="type-string sorttime" style="text-align:center;;cursor: pointer;">Thời gian</th>
                <th width="140px" style="text-align:right;padding-right:30px;cursor: pointer;" class="type-string sortprice">Giá rẻ nhất</th>
                <th width="80px" align="center">&nbsp;</th>
                <th width="160px" align="center">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

