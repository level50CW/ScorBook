ALTER TABLE `statsfielding`
  DROP `Players_playerlinkid`,
  DROP `seasonid`;

ALTER TABLE `statsfielding_inning`
  DROP `Players_playerlinkid`;

ALTER TABLE `statshitting`
  DROP `Players_playerlinkid`,
  DROP `seasonid`;

ALTER TABLE `statshitting_inning`
  DROP `Players_playerlinkid`;

ALTER TABLE `statspitching`
  DROP `Players_playerlinkid`,
  DROP `seasonid`;

ALTER TABLE `statspitching_inning`
  DROP `Players_playerlinkid`;