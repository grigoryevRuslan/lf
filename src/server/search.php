<?php 

    if (!session_start()) die('Sessions does not work');

    include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/functions/functions.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/sdk/sphinx/config.php';

    renderHead('Результаты поиска', ''.$_SERVER['HTTP_HOST'].'/img/svg/logo.svg', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'Результаты поиска по запросу '.$_GET['q']);
?>

    <main>

        <?php 

            include_once $_SERVER['DOCUMENT_ROOT'].'/templates/header/header.php';
            include_once $_SERVER['DOCUMENT_ROOT'].'/templates/controls/controls.php'; 

        if (!empty($_GET['q'])) require("sdk/sphinx/sphinxapi.php");

        //Sanitise the input
        $q = isset($_GET['q'])?$_GET['q']:'';

        $q = preg_replace('/ OR /',' | ',$q);

        //If the user entered something
        if (!empty($q)) {
            //produce a version for display
            $qo = $q;

            if (strlen($qo) > 64) {
                $qo = '--complex query--';
            }
            
            if (1) {
                //Connect to sphinx, and run the query
                $cl = new SphinxClient();
                $cl->SetServer($CONF['sphinx_host'], $CONF['sphinx_port']);
                $cl->SetSortMode(SPH_SORT_EXTENDED, "@relevance DESC, @id DESC");
                $cl->SetMatchMode(SPH_MATCH_ANY);
                $cl->SetLimits(0,25); //humber of results, page 1 only for the moment
                
                $res = $cl->Query($q, $CONF['sphinx_index']);

                //Check for failure
                if (empty($res)) {
                    print "Query failed: -- please try again later.\n";
                    if ($CONF['debug'] && $cl->GetLastError())
                        print "<br/>Error: ".$cl->GetLastError()."\n\n";
                    return;
                } else {
                    //We have results to display!
                    if ($CONF['debug'] && $cl->GetLastWarning())
                        print "<br/>WARNING: ".$cl->GetLastWarning()."\n\n";
                    $query_info = "По запросу '".htmlentities($qo)."' получено ".count($res['matches'])." of $res[total_found] совпадений за $res[time] сек.\n";
                }
                
                if (is_array($res["matches"])) {
                    $ids = array_keys($res["matches"]);
                } else {
                    print "<pre class=\"results\">Нет результатов поиска для '".htmlentities($qo)."'</pre>";
                }
            }
            
            if (!empty($ids)) {

                $db = mysql_connect($CONF['mysql_host'],$CONF['mysql_username'],$CONF['mysql_password']) or die("ERROR: unable to connect to database");
                mysql_select_db($CONF['mysql_database'], $db) or die("ERROR: unable to select database");
                
                $sql = str_replace('$ids',implode(',',$ids),$CONF['mysql_query']);
                $result = mysql_query($sql) or die($CONF['debug']?("ERROR: mysql query failed: ".mysql_error()):"ERROR: Please try later");
                
                if (mysql_num_rows($result) > 0) {

                    $rows = array();
                    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                        $rows[$row['id']] = $row;
                    }
                    
                    $actual_size = count($rows);

                    if ($CONF['body'] == 'excerpt') {
                        $docs = array();
                        foreach ($ids as $c => $id) {
                            $docs[$c] = strip_tags($rows[$id]['body']);
                        }
                        $reply = $cl->BuildExcerpts($docs, $CONF['sphinx_index'], $q);
                    }
                    
                    ?> 
                    <div class="container advert results" id="search-results">
                    
                        <?php print "<pre class=\"results\">$query_info</pre>"; ?>

                        <ul class="results">
                            <?php foreach ($ids as $c => $id) {
                                $row = $rows[$id];
                                ?>
                                    <li class="result <?php echo $row['type']; ?>">
                                        
                                        <div class="result__badge">
                                            <?php if($row['type'] == 'found'){echo 'Найден';} else {echo 'Потерян';} ?>
                                        </div>

                                        <div class="result__content">

                                            <?php  if (isset($row['date_publish'])) {  ?>
                                                <span class="time">Добавлено: <?php echo $row['date_publish'] ?></span>
                                            <?php } ?>

                                            <a class="link" href="advert.php?id=<?php echo $row['id']; ?>"></a>
                                            
                                            <h3>
                                                <?php
                                                    if ($row['item'] == '') {
                                                        echo $row['user_item'];
                                                    } else {
                                                        echo $row['item'];
                                                    }
                                                ?>
                                            </h3>

                                            <p><?php echo $row['description']; ?></p>
                                            
                                            <?php if (isset($row['meta']) && $row['meta'] != "") { ?>
                                                <p class="meta">
                                                    <b>Тэги объявления: </b>
                                                    <span class="result-keywords">
                                                        <?php
                                                            $meta = explode(',', $row['meta']);
                                                            foreach ($meta as $metakey) {
                                                                $metatext = trim($metakey);
                                                                echo "<a href='http://".$_SERVER['HTTP_HOST']."/search.php?q=".$metatext."' class='result__tag'>".$metatext."</a>, ";
                                                            }
                                                        ?>
                                                    </span>
                                                </p>
                                            <?php } ?>

                                            <?php 
                                                if ($row['reward'] != 0) {
                                                    if ($row['type'] == 'found') { ?>
                                                        <span class="reward">Нашёл и отдам за: <?php echo $row['reward']; ?> грн.</span>
                                                    <?php } else { ?>
                                                        <span class="reward">Владелец обьявил награду: <?php echo $row['reward']; ?> грн.</span>
                                                    <?php }
                                                 } ?>
                                        </div>

                                        <div class="result__image">
                                            <?php if (isset($row['image_uri'])) {?>

                                                <img src="upload/<?php echo $row['image_uri']; ?>" alt="advert" />

                                            <?php }?>
                                        </div>
                                    </li>
                            <?php } ?>
                        </ul>

                    </div>
                    <?php 

                } else {
                    //Error Message
                    print "<pre class=\"results\">Unable to get results for '".htmlentities($qo)."'</pre>";
                }
            }
        }

    ?>
    
    </main>

    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/templates/footer/footer.php'; ?>
        
    <?php 
    
        if ( !$GLOBALS['isAuthorised'] ) {
            renderPopup('auth');
        } else {
            renderPopup('feedback');
        }

    ?>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&amp;render=explicit" async defer
    ></script>
    <script type="text/javascript" src="js/global/app.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/modules/ajax-auth.js"></script>
</body>
</html>