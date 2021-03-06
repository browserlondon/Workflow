<?php
namespace verbb\workflow\elements\db;

use verbb\workflow\elements\Submission;

use craft\elements\db\ElementQuery;
use craft\helpers\Db;

class SubmissionQuery extends ElementQuery
{
    public $ownerId;
    public $ownerSiteId;
    public $draftId;
    public $editorId;
    public $publisherId;
    public $editorNotes;
    public $publisherNotes;
    public $data;
    public $dateApproved;
    public $dateRejected;
    public $dateRevoked;

    public function ownerId($value)
    {
        $this->ownerId = $value;
        return $this;
    }

    public function draftId($value)
    {
        $this->draftId = $value;
        return $this;
    }

    public function ownerSiteId($value)
    {
        $this->ownerSiteId = $value;
        return $this;
    }

    public function editorId($value)
    {
        $this->editorId = $value;
        return $this;
    }

    public function publisherId($value)
    {
        $this->publisherId = $value;
        return $this;
    }

    public function dateApproved($value)
    {
        $this->dateApproved = $value;
        return $this;
    }

    public function dateRejected($value)
    {
        $this->dateRejected = $value;
        return $this;
    }

    public function dateRevoked($value)
    {
        $this->dateRevoked = $value;
        return $this;
    }

    protected function beforePrepare(): bool
    {
        $this->joinElementTable('workflow_submissions');

        $this->query->select([
            'workflow_submissions.*',
        ]);

        if ($this->ownerId) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.ownerId', $this->ownerId));
        }

        if ($this->draftId) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.draftId', $this->draftId));
        }

        if ($this->ownerSiteId) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.ownerSiteId', $this->ownerSiteId));
        }

        if ($this->editorId) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.editorId', $this->editorId));
        }

        if ($this->publisherId) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.publisherId', $this->publisherId));
        }

        if ($this->editorNotes) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.editorNotes', $this->editorNotes));
        }

        if ($this->publisherNotes) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.publisherNotes', $this->publisherNotes));
        }

        if ($this->data) {
            $this->subQuery->andWhere(Db::parseParam('workflow_submissions.data', $this->data));
        }

        if ($this->dateApproved) {
            $this->subQuery->andWhere(Db::parseDateParam('workflow_submissions.dateApproved', $this->dateApproved));
        }

        if ($this->dateRejected) {
            $this->subQuery->andWhere(Db::parseDateParam('workflow_submissions.dateRejected', $this->dateRejected));
        }

        if ($this->dateRevoked) {
            $this->subQuery->andWhere(Db::parseDateParam('workflow_submissions.dateRevoked', $this->dateRevoked));
        }

        return parent::beforePrepare();
    }

    protected function statusCondition(string $status)
    {
        switch ($status) {
            case Submission::STATUS_APPROVED:
                return [
                    'workflow_submissions.status' => Submission::STATUS_APPROVED,
                ];
            case Submission::STATUS_PENDING:
                return [
                    'workflow_submissions.status' => Submission::STATUS_PENDING,
                ];
            case Submission::STATUS_REJECTED:
                return [
                    'workflow_submissions.status' => Submission::STATUS_REJECTED,
                ];
            case Submission::STATUS_REVOKED:
                return [
                    'workflow_submissions.status' => Submission::STATUS_REVOKED,
                ];
            default:
                return parent::statusCondition($status);
        }
    }
}
