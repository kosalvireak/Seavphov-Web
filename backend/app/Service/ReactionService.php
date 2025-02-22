<?php

namespace App\Service;

use App\Models\Reaction;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ReactionService
{
    // model that use like and dislike entity must implement method_exists
    // increaseLike, decreaseLike, increaseDislike, decreaseDislike


    public static function likeEntity(Model $model, $entityId,  $userId, $entityType)
    {

        try {
            $existingReaction = Reaction::getFirstReactionByEntity($entityId, $userId, $entityType);

            if ($existingReaction != null) {
                // user either like or dislike
                if ($existingReaction->reaction == true) {
                    // user liked then like -> reduce like = no reaction

                    $model->decreaseLike();

                    $existingReaction->delete();

                    return response()->json([
                        'success' => true,
                        'message' => 'No reaction',
                        'reaction' => null,
                        'like' => $model->like,
                        'dislike' => $model->dislike
                    ], 200);
                } else {
                    // user disliked then like -> reduce dislike, add like 
                    $existingReaction->reaction = true;
                    $existingReaction->save();

                    $model->increaseLike();
                    $model->decreaseDislike();

                    return response()->json([
                        'success' => true,
                        'message' => 'Change to like',
                        'reaction' => true,
                        'like' => $model->like,
                        'dislike' => $model->dislike
                    ], 200);
                }
            } else {
                // user has no reaction -> create like record
                Reaction::create([
                    'user_id' => $userId,
                    'entity_id' => $entityId,
                    'reaction' => true,
                    'entity_type' => $entityType,
                ]);

                $model->increaseLike();

                return response()->json([
                    'success' => true,
                    'message' => 'You like a ' . $entityType,
                    'reaction' => true,
                    'like' => $model->like,
                    'dislike' => $model->dislike
                ], 200);
            }
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot like entity!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public static function dislikeEntity(Model $model, $entityId,  $userId, $entityType)
    {

        try {
            $existingReaction = Reaction::getFirstReactionByEntity($entityId, $userId, $entityType);

            if ($existingReaction != null) {
                // user either like or dislike
                if ($existingReaction->reaction == false) {
                    // user disliked then dislike -> reduce dislike

                    $model->decreaseDislike();

                    $existingReaction->delete();

                    return response()->json([
                        'success' => true,
                        'message' => 'No reaction',
                        'reaction' => null,
                        'like' => $model->like,
                        'dislike' => $model->dislike
                    ], 200);
                } else {
                    // user like then dislike -> reduce like, add dislike 
                    $existingReaction->reaction = false;
                    $existingReaction->save();

                    $model->increaseDislike();
                    $model->decreaseLike();

                    return response()->json([
                        'success' => true,
                        'message' => 'Change to dislike',
                        'reaction' => false,
                        'like' => $model->like,
                        'dislike' => $model->dislike
                    ], 200);
                }
            } else {
                // user has no reaction -> create dislike record
                Reaction::create([
                    'user_id' => $userId,
                    'entity_id' => $entityId,
                    'reaction' => false,
                    'entity_type' => $entityType,
                ]);

                $model->increaseDislike();

                return response()->json([
                    'success' => true,
                    'message' => 'You dislike a ' . $entityType,
                    'reaction' => false,
                    'like' => $model->like,
                    'dislike' => $model->dislike
                ], 200);
            }
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot dislike entity!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
