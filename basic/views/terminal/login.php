<?

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Вход в терминал';
//$this->params['breadcrumbs'][] = $this->title;
?> <div class="terminal-login">
    <h1 class="text-center mb-20"><?=Html::encode($this->title) ?></h1>
    <div id="pincode">
        <div class="table">
            <div class="cell">

                <div id="fields">
                    <div class="grid">
                        <div class="grid__col grid__col--1-of-4 numberfield"><span></span></div>
                        <div class="grid__col grid__col--1-of-4 numberfield"><span></span></div>
                        <div class="grid__col grid__col--1-of-4 numberfield"><span></span></div>
                        <div class="grid__col grid__col--1-of-4 numberfield"><span></span></div>
                    </div>
                </div>

                <div id="numbers">
                    <div class="grid">
                        <div class="grid__col grid__col--1-of-3"><button>1</button></div>
                        <div class="grid__col grid__col--1-of-3"><button>2</button></div>
                        <div class="grid__col grid__col--1-of-3"><button>3</button></div>

                        <div class="grid__col grid__col--1-of-3"><button>4</button></div>
                        <div class="grid__col grid__col--1-of-3"><button>5</button></div>
                        <div class="grid__col grid__col--1-of-3"><button>6</button></div>

                        <div class="grid__col grid__col--1-of-3"><button>7</button></div>
                        <div class="grid__col grid__col--1-of-3"><button>8</button></div>
                        <div class="grid__col grid__col--1-of-3"><button>9</button></div>

                        <div class="grid__col grid__col--1-of-3"></div>
                        <div class="grid__col grid__col--1-of-3"><button>0</button></div>
                        <div class="grid__col grid__col--1-of-3"></div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
