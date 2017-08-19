<?php

namespace App\Http\Controllers;

use App\Author;
use App\AuthorLog;
use App\Events\QuoteCreated;
use App\Quote;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Event;

class QuoteController extends Controller
{

    public function getIndex($author = null){

        if(!is_null($author)){
            $quote_author = Author::where('name', $author)->first();
            if($quote_author){
                $quotes = $quote_author->quotes()->orderBy('created_at', 'desc')->paginate(6);
            }
        }
        else{
            $quotes = Quote::orderBy('created_at','desc')->paginate(6);
        }
        return view('index', compact('quotes'));
    }

    public function postQuote(Request $request){

        $this->validate($request,[

            'author'=>'required|max:60|alpha',
            'quote' =>'required|max:500',
            'email' => 'required|email'

        ]);

        $authorText = ucfirst($request['author']);
        $quoteText = $request['quote'];

        $author = Author::where('name',$authorText)->first();
        if(!$author){
            $author = new Author();
            $author->name = $authorText;
            $author->email = $request['email'];
            $author->save();
        }
        $quote = new Quote();
        $quote->quote = $quoteText;
        $author->quotes()->save($quote);

        // ispaljivanje dogadjaja koji smo napravili za upis u log tabelu
        Event::fire(new QuoteCreated($author));

        return redirect()->route('index')->with([
            'success'=>'Quote saved!'
        ]);


//        return dd($request->all());

    }

    public function getDeleteQuote($quote_id){ // sve promenljive koje se proslejduju u ruti, index view i u kontorleru moraju imati isto ime

        $quote = Quote::findOrFail($quote_id);
        $author_deleted = false;
        if(count($quote->author->quotes) === 1){
            $quote->author->delete();
            $author_deleted = true;
        }
        $quote->delete();
        $msg = $author_deleted ? 'Quote and author deleted!' : 'Quote deleted!';
        return redirect()->route('index')->with(['success' => $msg]);
    }

    public function getMailCallback($author_name){

        $author = $author_name;
        $author_log = new AuthorLog();
        $author_log->author = $author_name;
        $author_log->save();
        return view('email.callback',compact('author'));

    }
}
