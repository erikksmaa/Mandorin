@props(['disabled' => false])

<input @disabled($disabled) {!! $attributes->merge(['class' => 'border-slate-300 focus:border-gold focus:ring-gold rounded-2xl shadow-sm']) !!}>