
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create{{ ucwords(str_plural($nameModel)) }}Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ str_plural(strtolower($nameModel)) }}', function (Blueprint $table) {
            $table->uuid('{{ $id['name'] }}')->unique()->primary('{{ $id['name'] }}');

            @foreach ($jsonContent as $field)
{!! $field !!}
            @endforeach

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ str_plural(strtolower($nameModel)) }}');
    }
}
