<?php

namespace app\models;

use Yii;
use app\models\PostAction;
use app\models\PostComment;
/**
 * This is the model class for table "tbl_post".
 *
 * @property integer $id
 * @property string $title
 * @property string $img
 * @property string $content
 * @property string $author
 * @property string $source_name
 * @property string $source_url
 * @property string $tag
 * @property integer $category_id
 * @property integer $type
 * @property integer $status
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'img', 'content', 'category_id', 'status', 'user_id'], 'required', 'message' => '{attribute}不能为空'],
            [['img', 'content', 'tag', 'author', 'source_name', 'source_url', 'desc'], 'string'],
            [['category_id', 'type', 'status', 'user_id', 'created', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 999]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'img' => '图片',
            'content' => '内容',
            'desc' => '摘要',
            'author' => '作者',
            'source_name' => '来源名',
            'source_url' => '来源网址',
            'tag' => '标签',
            'category_id' => '分类',
            'type' => '类型',
            'status' => '状态',
            'user_id' => 'User ID',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function beforeSave($insert) 
    {   
        if (parent::beforeSave($insert)) 
        {
            $this->updated = time();
            if ($insert) 
            {
                $this->created = $this->updated;
            }  
            return true;
        } 
        else 
        {
            return false;
        } 
    }  

    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'user_id']);
    }  

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }  

    public function getUrl()
    {
        return url(['/post/view', 'id' => $this->id]);
    }  

    public function isLikedByUser($user_id)
    {
        $fav = sql(' select id from {{%post_action}} where user_id = :user_id and post_id = :post_id and type = :type ')
                        ->bindValues([':user_id' => $user_id, ':post_id' => $this->id, ':type' => PostAction::TYPE_LIKE])->queryScalar();
        return $fav != null;
    }

    public function getLikeCount()
    {
        return sql(' select count(*) from {{%post_action}} where post_id = :post_id and type = :type ')
                ->bindValues([':post_id' => $this->id, ':type' => PostAction::TYPE_LIKE])->queryScalar();
    }

    public function getDisLikeCount()
    {
        return sql(' select count(*) from {{%post_action}} where post_id = :post_id and type = :type ')
                ->bindValues([':post_id' => $this->id, ':type' => PostAction::TYPE_DISLIKE])->queryScalar();
    }    

    public function getCommentCount()
    {
        return sql(' select count(*) from {{%post_comment}} where post_id = :post_id ')
                ->bindValues([':post_id' => $this->id])->queryScalar();
    }

    public function getComment()
    {
        $post_comment = PostComment::findBySql("select * from {{%post_comment}} where post_id = :post_id",[':post_id' => $this->id])->all();
        return $post_comment;
    }

   // public function getFavoritePost()
   //  {
   //      $post_id = sql(' select post_id from {{%post_action}} where type = :type group by post_id order by count(post_id) desc limit 2')
   //                  ->bindValues([':type' => PostAction::TYPE_LIKE])->queryScalar();

   //      return $post_id;
   //      //找到postid
   //      //load post find the post title
   //  } 
}
