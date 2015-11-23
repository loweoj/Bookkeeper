<?php  namespace Bookkeeper\Repo\Record;

use Bookkeeper\Repo\Category\CategoryInterface;
use Bookkeeper\Repo\Stream\StreamInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Record;

class EloquentRecord implements RecordInterface
{

    /**
     * @var Model
     */
    protected $record;

    /**
     * @var CategoryInterface
     */
    protected $category;

    /**
     * @var StreamInterface
     */
    protected $stream;

    /**
     * The current query
     *
     * @var \Illuminate\Database\Query\Builder
     */
    private $query;

    /**
     * @param Model             $record
     * @param CategoryInterface $category
     * @param StreamInterface   $stream
     */
    public function __construct(Model $record, CategoryInterface $category, StreamInterface $stream)
    {
        $this->record = $record;
        $this->category = $category;
        $this->stream = $stream;

        // Start a new query
        $this->resetQuery();
    }

    /**
     * Creates draft records for a given bank account
     * @param $draftRecords
     * @param $bankAccountId
     * @return EloquentCollection
     */
    public function createDraftRecordsForAccount($draftRecords, $bankAccountId)
    {
        $collection = new EloquentCollection();

        // Strip transaction model data
        foreach($draftRecords as $recordAtts)
        {
            $recordAtts['account_id'] = $bankAccountId;
            $recordAtts['status'] = 'draft';

            // Create a default stream field in streams and find the stream?
            if( ! isset($recordAtts['stream_id']) ){
                $recordAtts['stream_id'] = 1;
            }

            $record = new Record($recordAtts);
            if( $record->save() ) {
                $collection->add($record);
            } else {
                // TODO: Better error handling for validation errors?
                return $record->getErrors();
            }
        }

        return $collection;
    }


    public function find($id)
    {
        return $this->record->find($id);
    }

    public function getDrafts()
    {
        $this->query->whereStatus('draft');

        // Order by created_at!!
        // $this->query->orderBy('created_at');
        return $this->all();
    }

    /**
     * @return $this
     */
    public function getIncome()
    {
        $this->query->whereType('income');

        return $this;
    }

    /**
     * @return $this
     */
    public function getExpenses()
    {
        $this->query->whereType('expense');

        return $this;
    }

    public function byType($type)
    {
        if ($type == 'income') {
            $this->query->whereType('income');

            return $this;
        }
        $this->query->whereType('expense');

        return $this;
    }

    /**
     * @param $category_id_or_name
     * @return $this
     */
    public function byCategory($category_id_or_name)
    {
        $category = $this->category->byNameOrId($category_id_or_name);
        $this->query->whereCategoryId($category->id);

        return $this;
    }

    /**
     * @param $payee
     * @return $this
     */
    public function byPayee($payee)
    {
        $this->query->where('payee', 'LIKE', '%' . $payee . '%');

        return $this;
    }

    /**
     * @param $stream
     * @return $this
     */
    public function byStream($stream)
    {
        $stream = $this->stream->byNameorId($stream);
        $this->query->where('stream', $stream->id);

        return $this;
    }

    /**
     * Returns all of the Resources.
     *
     * @return Model[]
     */
    public function all()
    {
        // Find for a specific status, or get approved
        if( isset($this->withStatus)) {
            $this->query->whereStatus($this->withStatus);
        } else {
            // $this->query->whereStatus('approved');
        }

//        if(empty($this->query->orders) ) {
//            $this->query->orderBy('date', 'desc')
//        }
        $results = $this->query
            ->with('category', 'stream', 'attachment')
            ->orderBy('date', 'desc')
            ->get();

        $this->resetQuery();

        return $results;
    }

    /**
     * Create a new builder instance on $this->query for use
     * in constructing a query. Resets the current query,
     * ready for use in a new query.
     *
     * $this->query = \Illuminate\Database\Query\Builder
     *
     * @return void
     */
    protected function resetQuery()
    {
        $this->query = with(new \Record)->newQuery();
    }
}