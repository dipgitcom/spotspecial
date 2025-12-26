<?php

namespace App\Jobs;

use Log;
use App\Models\Product;
use App\Mail\SendMailForNewProduct;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $newsletters;
    protected $productId;

    public function __construct(array $newsletters, int $productId)
    {
        $this->newsletters = $newsletters;
        $this->productId = $productId;
    }

    public function handle(): void
    {
        $product = Product::find($this->productId);

        if (!$product) {

            return;
        }

        foreach ($this->newsletters as $email) {
            Mail::to($email)->send(new SendMailForNewProduct($product));
        }
    }
}
