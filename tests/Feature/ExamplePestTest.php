<?php

test('the application return a successful response')
->get('/')
->assertSuccessful();