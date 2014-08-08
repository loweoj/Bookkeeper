<?php namespace Bookkeeper\Repo;

use Attachment;
use Bookkeeper\Repo\Attachment\EloquentAttachment;
use Bookkeeper\Repo\Category\EloquentCategory;
use Bookkeeper\Repo\Record\EloquentRecord;
use Bookkeeper\Repo\Rule\EloquentRule;
use Bookkeeper\Repo\Statements\EloquentStatement;
use Bookkeeper\Repo\Stream\EloquentStream;
use Bookkeeper\Repo\Transaction\EloquentTransaction;
use Category;
use Illuminate\Support\ServiceProvider;
use Record;
use Rule;
use Stream;
use Transaction;

class RepoServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // Record
        $app->bind('Bookkeeper\Repo\Record\RecordInterface', function ($app) {
            $record = new EloquentRecord(
                new Record,
                $app->make('Bookkeeper\Repo\Category\CategoryInterface'),
                $app->make('Bookkeeper\Repo\Stream\StreamInterface')
            );

            return $record;
        });

        // Statement
        $app->bind('Bookkeeper\Repo\Statement\StatementInterface', function ($app) {
            return new EloquentStatement(
                new Stream,
                $app->make('Bookkeeper\Repo\Transaction\TransactionInterface')
            );
        });

        // Transaction
        $app->bind('Bookkeeper\Repo\Transaction\TransactionInterface', function ($app) {
            return new EloquentTransaction(
                new Transaction
                // $app->make('Bookkeeper\Repo\Transaction\TransactionInterface')
            );
        });

        // Attachment
        $app->bind('Bookkeeper\Repo\Attachment\AttachmentInterface', function ($app) {
            return new EloquentAttachment(
                new Attachment
            );
        });

        // Rule
        $app->bind('Bookkeeper\Repo\Rule\RuleInterface', function ($app) {
            return new EloquentRule(
                new Rule
            );
        });

        // Category
        $app->bind('Bookkeeper\Repo\Category\CategoryInterface', function ($app) {
            return new EloquentCategory(
                new Category
            );
        });

        // Stream
        $app->bind('Bookkeeper\Repo\Stream\StreamInterface', function ($app) {
            return new EloquentStream(
                new Stream
            );
        });
    }
}