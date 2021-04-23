<?php


class PaletteDao {
    private const PALETTE_TABLE = 'palette';

    private const COL_ID = 'id';
    private const COL_NAME = 'name';
    private const COL_FIRST = 'first_color';
    private const COL_SECOND = 'second_color';
    private const COL_THIRD = 'third_color';

    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function getColorPalettes() {
        $data = $this->retrieveAll(self::PALETTE_TABLE);

        return $this->paletteListFromAssoc($data);
    }

    public function paletteById($id) {
        $data = $this->retrieveAll(self::PALETTE_TABLE, [self::COL_ID." = $id"]);

        if (count($data) == 0) return null;

        return $this->paletteFromAssoc($data[0]);
    }

    public function paletteListFromAssoc($assoc) {
        $palettes = array();

        foreach($assoc as $item) {
            $palettes[] = $this->paletteFromAssoc($item);
        }

        return $palettes;
    }

    public function paletteFromAssoc($assoc) {
        $palette = new Palette();

        $palette->id = $assoc[self::COL_ID];
        $palette->name = $assoc[self::COL_NAME];
        $palette->firstColor = $assoc[self::COL_FIRST];
        $palette->secondColor = $assoc[self::COL_SECOND];
        $palette->thirdColor = $assoc[self::COL_THIRD];

        return $palette;
    }
}