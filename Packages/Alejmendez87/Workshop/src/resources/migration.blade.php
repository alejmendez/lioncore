
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ Illuminate\Support\Str::plural(strtolower($nameModel)) }}', function (Blueprint $table) {
            $table->uuid('{{ $id['name'] }}')->unique()->primary('{{ $id['name'] }}');

@foreach ($fields as $field)
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
        Schema::dropIfExists('{{ Illuminate\Support\Str::plural(strtolower($nameModel)) }}');
    }
};
