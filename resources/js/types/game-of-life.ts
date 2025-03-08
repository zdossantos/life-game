export type Cell = {
    alive: 0 | 1;
    color: string;
};
export type Grid = Cell[][];

export interface GameSettings {
    gridSize: number;
    updateSpeed: number;
    selectedColor: string;
    neighborThresholds: {
        surviveMin: number;
        surviveMax: number;
        birthCount: number;
    };
}

export interface GamePreset {
    name: string;
    grid: Grid;
    settings: GameSettings;
}
