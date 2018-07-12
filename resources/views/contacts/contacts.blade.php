
<div class="container" id="contacts-container">

    <div class="row">
        <div class="col-md-12">
            <h5>Névjegyzék</h5>
        </div>
        <section class="col-12">
            <p class="text-right">
                <i class="fa fa-plus-square-o " style="font-size: 1.4rem" aria-hidden="true" data-toggle="collapse"
                   href="#userContacts" aria-expanded="false" aria-controls="userContacts"></i>
            </p>
        </section>

        <div class="col-md-12">



            <div class="row collapse" id="userContacts">
                <div class="col-md-12">
                    contact felvitel

                    <div class="form-group col-6">
                        <label for="">Név *</label>
                        <input type="text" id="contact_name" class="form-control" autocomplete="off" required/>
                    </div>

                    <div class="form-group col-6">
                        <label for="">E-mail *</label>
                        <input type="email" id="contact_email" class="form-control" autocomplete="off" required/>
                    </div>

                    <div class="form-group col-6">
                        <label for="">Telefon</label>
                        <input type="text" id="contact_phone" class="form-control" autocomplete="off"/>
                    </div>

                    <div class="form-group col-6">
                        <label for="">Cím</label>
                        <input type="text" id="contact_address" class="form-control" autocomplete="off"/>
                    </div>

                    <button class="btn btn-primary" id="saveContact">Mentés</button>


                </div>
            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped" id="contacts">
                <thead>
                <tr>
                    <th>Név</th>
                    <th>Telefon</th>
                    <th>E-mail</th>
                    <th>Cím</th>
                </tr>
                </thead>
                <tbody id="contact-list"></tbody>
            </table>
        </div>



    </div>
</div>


