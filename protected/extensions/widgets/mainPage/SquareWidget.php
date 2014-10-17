<?php

class SquareWidget extends ExtendedWidget
{
    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'ROUND(SUM(square),1) as square';
        $criteria->condition = 'busy=:busy';
        $criteria->params = array(':busy'=>1);

        $res = MapArea::model()->find($criteria);
        $busySquare = ($res->square != null)? $res->square : 0;

        if ((int)$busySquare == $busySquare)
            $busySquare = (int)$busySquare;

        $this->render('square', array(
            'totalSquare' => MapArea::TOTAL_SQUARE,
            'busySquare' => $busySquare,
            'freeSquare' => MapArea::TOTAL_SQUARE - $busySquare
        ));
    }
}
