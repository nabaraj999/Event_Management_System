    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
                $table->string('page_key')->unique(); // e.g., 'home', 'about', 'contact', 'blog.index'
                $table->string('locale')->default('en'); // For multi-language support (optional now, ready for future)
                $table->string('meta_title', 255)->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->string('og_title', 255)->nullable();
                $table->text('og_description')->nullable();
                $table->string('og_image')->nullable(); // Store path or full URL
                $table->string('canonical_url')->nullable();
                $table->string('robots')->default('index, follow');
                $table->json('extra_meta')->nullable(); // For custom meta tags (e.g., twitter:card)
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                // Composite unique index for multi-language
                $table->unique(['page_key', 'locale']);
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('seo_pages');
        }
    };
