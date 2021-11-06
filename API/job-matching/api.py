from flask import Flask
from flask_restful import Resource, Api

import json
import nltk
nltk.download("averaged_perceptron_tagger")
nltk.download("stopwords")
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer


app = Flask(__name__)
api = Api(app)

class Skill(Resource):
    def get(self):
        lemmatizer = WordNetLemmatizer()

        # stop_words = set(stopwords.words('english'))
        stop_words = []

        word = "Expert in web development using Javascript and PHP. Knowledgeable on web design using adobe XD. knew different languages for making websites."

        tok = word_tokenize(word)

        filtered_list = []

        for word in tok:
            if word.casefold() not in stop_words:
                filtered_list.append(lemmatizer.lemmatize(word.casefold()))

        tagged = nltk.pos_tag(filtered_list)

        return tagged

api.add_resource(Skill, '/skill')

if __name__ == '__main__':
    app.run(debug=True)