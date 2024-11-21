<?php

namespace app\models;

use yii\db\ActiveRecord;
use Exception;
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    // public $id;
    // public $username;
    // public $password;
    // public $authKey;
    // public $accessToken;
    public $password_repeat;
    public static function tableName()
    {
        return 'users';  // Asegúrate de que el nombre sea correcto
    }

    public function rules()
    {
        return [
            [['username','password'], 'required'],
            ['username', 'unique'],
            ['username', 'string','length'=>[4,100]],
            ['bio', 'default'],
            ['password', 'compare','compareAttribute'=>'password_repeat'],
            ['password_repeat', 'default'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'usuario',
        ];
    }

    public function attributeHints()
    {
        return [
            'username' => 'debera ser unico en el sistema',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = self::findOne($id);
        if(empty($user))
        {
            return null;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['token' => $token]);

        if(empty($user))
        {
            return null;
        }
        return $user;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()->where(['username' => $username])->one();

        if(empty($user))
        {
            return null;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $this->ofuscatePassword($password);
    }

    public function ofuscatePassword($password)
    {
        if(empty(getenv('salt')))
        {
            throw new Exception('no salt');
        }
        return md5(sprintf('%s-%s-s',$password,$this->username,getenv('salt')));
    }

    public function beforeSave($insert)
    {
        if($insert == true)
        {
            $this->password = $this->ofuscatePassword($this->password);
        }
        return parent::beforeSave($insert);
    }

    public function hasBook($book_id):bool
    {
        $ub = UserBook::find()->where([
            'user_id' => $this->id,
            'book_id' => $book_id
        ])-> all();
        if(empty($ub))
        {
            return false;
        }
        return true;
    }

    public function getVotes()
    {
        return $this->hasMany(BookScore::class, ['user_id' => 'user_id'])->all();
    }

    public function getVoteCount()
    {
        return count($this->votes);
    }

    public function getVoteAvg()
    {
        $i = 0;
        $sum = 0;
        foreach($this->votes as $vote)
        {
            $i++;
            $sum += $vote->score;
        }
        if($i == 0)
        {
            return "Sin votos";
        }
        return sprintf("%0.2f (%d votos)", $sum/$i, $i);
    }

    public function hasVotedFor($book_id)
    {
        $bs = BookScore::find()
        ->where([
            'book_id'=> $book_id,
            'user_id' => $this->id,
        ])
        ->one();
        if(empty($bs))
        {
            return false;
        }
        return true;
    }

    public function getVotedForBook($book_id)
    {
        $bs = BookScore::find()
        ->where([
            'book_id'=> $book_id,
            'user_id' => $this->id,
        ])
        ->one();
        if(empty($bs))
        {
            return false;
        }
        return $this->hasOne(BookScore::class, ['user_id' => 'user_id'])
            ->where(['book_id' => $book_id])
            ->one();
    }
}
