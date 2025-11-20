<?php

namespace App\ML;

use Phpml\Regression\LeastSquares;
use Phpml\ModelManager;

class PredictiveMaintenance
{
    protected static $modelPath = 'app/ml/tool_condition.model';

    public static function train(array $samples, array $targets)
    {
        $regression = new LeastSquares();
        $regression->train($samples, $targets);

        $manager = new ModelManager();
        $manager->saveToFile($regression, storage_path(self::$modelPath));
    }

    public static function predict(array $input)
    {
        $manager = new ModelManager();
        $model = $manager->restoreFromFile(storage_path(self::$modelPath));

        return $model->predict($input);
    }
}
