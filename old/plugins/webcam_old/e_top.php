<?php
if (!defined('e107_INIT'))
{
    exit;
}
    include_lan(e_PLUGIN . "webcam/languages/" . e_LANGUAGE . ".php");
// $TOP_PLUGIN_SECTIONS[]=array(,);
// top items by views
// data in the order item name, poster (ID.name),category,date posted,link,additional info
// .
// Top recipes by views
unset($TOP_VIEWS);
global $sql, $top_tc;
global $TOP_PREFS, $top_limitname, $top_limitmode;
$webcam_arg = "select * from #webcams where webcam_approved>0 order by webcam_views desc limit 0," . $top_tc->limit();
$sql->db_Select_gen($webcam_arg, false);
while ($webcam_row = $sql->db_Fetch())
{
    $TOP_VIEWS[] = array($webcam_row['webcam_name'],
        $webcam_row['webcam_poster'],
		"",
        $webcam_row['webcam_updated'],
        e_PLUGIN . "webcam/webcam.php?0.view." . $webcam_row['webcam_id'],
        WCAM_54." " . $webcam_row['webcam_views']);
} // while
// Top by rating
unset($TOP_RATE);
$webcam_arg = "select r.*,m.* from #rate as r
left join #webcams as m on rate_itemid=webcam_id
where rate_table='webcams' and webcam_approved > 0
order by rate_rating desc
limit 0," . $top_tc->limit();
$sql->db_Select_gen($webcam_arg, false);
while ($webcam_row = $sql->db_Fetch())
{
    $TOP_RATE[] = array($webcam_row['webcam_name'],
        $webcam_row['webcam_poster'],
        "",
        $webcam_row['webcam_updated'],
        e_PLUGIN . "webcam/webcam.php?0.view." . $webcam_row['webcam_id'],
        WCAM_56." " . number_format($webcam_row['rate_rating'] / $webcam_row['rate_votes'], 2) . " ".WCAM_59." " . $webcam_row['rate_votes'] . " ".WCAM_58);
} // while
// Top Poster
unset($TOP_POSTER);
$webcam_arg = "select *,count(webcam_poster) as numpost from #webcams where webcam_approved > 0 group by webcam_poster order by numpost  desc limit 0," . $top_tc->limit();
$sql->db_Select_gen($webcam_arg, false);

while ($webcam_row = $sql->db_Fetch())
{
    $TOP_POSTER[] = array(WCAM_60." " . $webcam_row['numpost'],
        $webcam_row['webcam_poster'],
        "",
        "",
        "",
        ""
        );
} // while
unset($TOP_COMMENT);
$webcam_arg = "select count(c.comment_item_id) as numpost,m.* from #comments as c
left join #webcams as m on comment_item_id =webcam_id
where webcam_approved > 0 and comment_type='webcams' group by comment_item_id order by numpost desc limit 0," . $top_tc->limit();

$sql->db_Select_gen($webcam_arg, false);
while ($webcam_row = $sql->db_Fetch())
{
    $TOP_COMMENT[] = array($webcam_row['webcam_name'],
        $webcam_row['webcam_poster'],
        "",
        $webcam_row['webcam_updated'],
        e_PLUGIN . "webcam/webcam.php?0.view." . $webcam_row['webcam_id'],
        WCAM_63." " . $webcam_row['numpost']);
} // while

$TOP_MENU_DATA[] = array(
	WCAM_55 => $TOP_VIEWS,
	WCAM_57 => $TOP_RATE,
	WCAM_61 => $TOP_POSTER,
	WCAM_62 => $TOP_COMMENT);
?>