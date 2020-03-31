<?php

use Kalnoy\Nestedset\NestedSet;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTaxonomyTables
 */
class CreateTaxonomyTables extends Migration
{
    /**
     * Terms table name.
     *
     * @var string
     */
    protected $termsTable;

    /**
     * Term taxonomy table name.
     *
     * @var string
     */
    protected $termTaxonomyTable;

    /**
     * Term relationships table name.
     *
     * @var string
     */
    protected $termRelationshipsTable;

    /**
     * Create a new migration.
     *
     * @return void
     */
    public function __construct()
    {
        $this->termsTable = config('taxonomy.tables.terms');
        $this->termTaxonomyTable = config('taxonomy.tables.term_taxonomy');
        $this->termRelationshipsTable = config('taxonomy.tables.term_relationships');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->upTermTaxonomyTable();
        $this->upTermsTable();
        $this->upTermRelationshipsTable();
    }

    /**
     *
     */
    public function upTermTaxonomyTable(): void
    {
        Schema::create($this->termTaxonomyTable, static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('term_id')->nullable()->index();
            $table->string('taxonomy', 32)->index();
            $table->longText('description')->nullable();

            // Add nested set columns to table.
            // Check docs for more info.
            NestedSet::columns($table);

            $table->timestamps();
        });
    }

    /**
     *
     */
    public function upTermsTable(): void
    {
        Schema::create($this->termsTable, static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200)->index();
            $table->string('slug', 200)->index();
            $table->bigInteger('term_group')->default(0);
            $table->timestamps();

            // $table->foreign('id')->references('term_id')->on('term_taxonomy')
            //     ->onUpdate('cascade');
        });
    }

    /**
     *
     */
    public function upTermRelationshipsTable(): void
    {
        Schema::create($this->termRelationshipsTable, static function (Blueprint $table) {
            $table->morphs(config('taxonomy.morph_name'));
            $table->unsignedBigInteger('taxonomy_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->termsTable);
        Schema::dropIfExists($this->termTaxonomyTable);
        Schema::dropIfExists($this->termRelationshipsTable);
    }
}
