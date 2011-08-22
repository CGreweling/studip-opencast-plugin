<? if (isset($message)): ?>
  <?= MessageBox::success($message) ?>
<? endif ?>

<?
$infobox_content = array(array(
    'kategorie' => _('Hinweise:'),
    'eintrag'   => array(array(
        'icon' => 'icons/16/black/info.png',
        'text' => _("Hier k�nnen die eingebundenen Vorlesungsaufzeichnungen aus dem angebundenen Opencast Matterhorn System verwaltet werden. Sie k�nnen Series, die noch keiner Veranstaltung zugeordnet sind der aktuellen Verantstaltung zuordnen. Wenn Sie bestehende Zuordnungen l�schen m�chten, klichen Sie auf den jeweiligen M�lleimer.")
    ))
));

$infobox = array('picture' => 'infobox/administration.jpg', 'content' => $infobox_content);
?>
<script language="JavaScript">
OC.initAdmin();
</script>
<h3><?=_('Verwaltung der eingebundenen Vorlesungsaufzeichnungen')?></h3>
<div id="admin-accordion">
    <h3><?=_('Veranstaltungsaufzeichnungen Planen')?>:</h3>
    <div class="oc_schedule">
        <h4>Ablaufplan</h4>
        <p>Erst feststellen ob ein Raum mit CA da ist und dann den Ablaufplan posten mit Checkboxes zum Schedulen...</p>
        <table class="default">
            <tr>
                <th>Termin</th>
                <th>Titel</th>
                <th>Aktionen</th>
            </tr>
            
            <? foreach($dates as $d) : ?>
                <tr>
                <? $date = new SingleDate($d['termin_id']); ?>
                <td> <?=$date->getDatesHTML()?> </td>
                <? $issues = $date->getIssueIDs(); ?>
                <? if(is_array($issues)) : ?>
                    <? foreach($issues as $is) : ?>
                        <? $issue = new Issue(array('issue_id' => $is));?>
                        <td> <?= my_substr($issue->getTitle(), 0 ,80 ); ?></td>
                    <? endforeach; ?>
                <? else: ?>
                        <td> <?=_("Kein Titel eingetragen")?></td>
                <? endif; ?>
                <td>
                    <? $resource = $date->getResourceID(); ?>
                    <? if(isset($resource)) :?>
                        <?= Assets::img('icons/16/blue/date.png', array('title' => _("Aufzeichnung planen"))) ?>
                    <?
                        /*
                         * Hier dann die Aufzeichnung Planen...
                         * -> Wenn Resoucre OC Ready ist, dann planen
                         * -> sonst hinweisen...
                         */
                    ?>
                        <?// $date->getRoom() ?>
                    <? elseif(false) : ?>
                        <?= Assets::img('icons/16/blue/video.png') ?>
                    <?
                        /*  Wenn es eine Aufzeichnung gibt, optionen zum Unsichtbar machen anbieten
                         *  Wenn keine Aufzeichnung aus OC gibt dann ersma nix machen
                         *
                         *
                         */
                    ?>
                    <? else : ?>
                        <?= Assets::img('icons/16/red/exclaim-circle.png', array('title' =>  _("Es wurde bislang kein Raum gebucht"))) ?>
                    <? endif; ?>


                </td>
                </tr>
            <? endforeach; ?>
            


        </table>
    </div>


    <h3><?=_('W�hlen Sie rechts eine Series aus, die Sie mit der aktuellen Veranstaltung verkn�pfen m�chten')?>:</h3>
    <div>
        <? if (sizeof($series) == 0) : ?>
            <?= MessageBox::info(_("Es sind bislang noch keine Series verf�gbar. Bitte �berpr�fen Sie die globalen Opencast Matterhorn Einstellungen.")) ?>
        <? else : ?>
        <form action="<?= PluginEngine::getLink('opencast/course/edit/'.$course_id) ?>"
            method=post>
            <div style="dislay:inline;vertical-align:middle">
                <div style="float:left;">
                    <p><?//=_("Zugeordnete Series")?></p>
                    <ul style="list-style-type: none;margin:0;padding-left:50px">
                        <? if(!empty($cseries)) :?>
                        <? foreach($cseries as $serie) :?>
                            <li>
                                <? $s = $series_client->getSeries($serie['series_id']); ?>
                                <?=  OCModel::getMetadata($s->series->additionalMetadata, 'title')?>
                                <a href="<?=PluginEngine::getLink('opencast/course/remove_series/'.$course_id.'/'.$serie['series_id'])?>">
                                    <?= Assets::img('icons/16/blue/trash.png', array('title' => _('Zuordnung l�schen'), 'alt' => _('Zuordnung l�schen')))?>
                                </a>
                            </li>
                        <? endforeach ?>
                        <? else : ?>
                            <li style="padding-top:5px">
                                <p><?=_("Bislang wurde noch keine Series zugeordnet.")?></p>
                            </li>
                        <? endif ?>
                    </ul>
                </div>
                <div style="float:center;text-align:center">
                    <p> <?//=_("Series ohne Zuordnung")?></p>
                    <? if(!empty ($rseries) || true) :?>


                    <select multiple="multiple" name="series[]" size="10">
                        <? foreach($rseries as $serie) :?>
                            <? $s = $series_client->getSeries($serie['series_id']); ?>
                            <? if($s->series->additionalMetadata !=null) : ?>
                                <option value="<?=$serie['series_id']?>">
                                    <?=  OCModel::getMetadata($s->series->additionalMetadata, 'title')?>
                                </option>
                            <? endif ?>
                        <? endforeach ?>
                    </select>
                    <? endif ?>
                </div>
            </div>
            <div style="padding-top:2em;clear:both" class="form_submit">
                <?= makebutton("uebernehmen","input") ?>
                <a href="<?=PluginEngine::getLink('opencast/course/index')?>"><?= makebutton("abbrechen")?></a>
            </div>
        </form>
        <? endif;?>
    </div>
</div>