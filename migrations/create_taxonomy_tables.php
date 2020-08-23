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
     * @return void
     */
    public function upTermTaxonomyTable(): void
    {
        Schema::create($this->termTaxonomyTable, static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('term_id')->nullable()->index();
            $table->string('type', 32)->index();
            $table->longText('description')->nullable();
            $table->schemalessAttributes('meta');

            // Add nested set columns to table.
            // Check docs for more info.
            NestedSet::columns($table);

            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function upTermsTable(): void
    {
        Schema::create($this->termsTable, static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200)->index();
            $table->string('slug', 200)->index();
            $table->schemalessAttributes('meta');
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function upTermRelationshipsTable(): void
    {
        Schema::create($this->termRelationshipsTable, static function (Blueprint $table) {
            $table->morphs(config('taxonomy.morph_name'));
            $table->string('taxonomy_type');
            $table->unsignedBigInteger('taxonomy_id')->index();
            $table->schemalessAttributes('meta');
            $table->timestamps();
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
