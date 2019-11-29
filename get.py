from flask import Flask
from flask import request
from flask_restful import Resource, Api
from flask_restful import reqparse
from flaskext.mysql import MySQL
from flask_cors import CORS, cross_origin
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd
import re
import string
from sklearn.feature_extraction.stop_words import ENGLISH_STOP_WORDS as stop_words
from nltk.stem import PorterStemmer
from nltk.tokenize import word_tokenize
import numpy as np
from gensim.models import Word2Vec
from numpy import dot
from numpy.linalg import norm
import math
import pickle
mysql = MySQL()
app = Flask(__name__)
cors = CORS(app, resources={r"/": {"origins": "*"}})
cors = CORS(app, resources={r"/rec/": {"origins": "*"}})
app.config['CORS_HEADERS'] = 'Content-Type'


#MySQL configurations
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = ''
app.config['MYSQL_DATABASE_DB'] = 'store'
app.config['MYSQL_DATABASE_HOST'] = 'localhost'

mysql.init_app(app)
api = Api(app)

import json
class embed:
    def __init__(self):
        self.pro_emb=[]





def get_sim(a,b):
     return dot(a, b)/(norm(a)*norm(b))

def create_model():
    frame = pd.read_csv('data.csv', index_col=None, header=0)
    stemmer= PorterStemmer()
    sentences=[]
    for i,row in frame.iterrows():
        s=row[0]
        s=s.lower()

        s=re.sub(r'\d+','',s)

        for c in string.punctuation:
            s=s.replace(c,"")
        tup=word_tokenize(s)
        interm=[]
        for j in range(len(tup)):
            if tup[j] not in stop_words and tup[j]!="amazon":
                tup[j]=stemmer.stem(tup[j])
                interm.append(tup[j])
        sentences.append(interm)

        s=tup
    model=Word2Vec(sentences,window=5,min_count=30,size=28)
    model.save('model.bin')






def get_Scraped(pro_name):
    stemmer= PorterStemmer()
    sentences=[]
    for row in pro_name:
        s=(row)
        s=s.lower()

        s=re.sub(r'\d+','',s)

        for c in string.punctuation:
            s=s.replace(c,"")
        tup=word_tokenize(s)
        interm=[]
        for j in range(len(tup)):
            if tup[j] not in stop_words and tup[j]!="amazon":
                tup[j]=stemmer.stem(tup[j])
                interm.append(tup[j])
        sentences.append(interm)
        s=tup
    return sentences



def main_Rec(products):
    recommendation=[]
    itemlist=[]
    namelist=[]
    #create_model()
    dataset = pd.read_csv('data.csv')
    dataset['ID']=[i for i in range(len(dataset))]
    pro_name=list(dataset['Product_Name'])
    model = Word2Vec.load('model.bin')
#     embedding_obj=embed()
#     embedding_obj.pro_emb=get_Scraped(pro_name)
#     pickle_out = open("product_embeddings.pkl","wb")
#     pickle.dump(embedding_obj, pickle_out)
#     pickle_out.close()
    with open('product_embeddings.pkl', 'rb') as inp:
        embedding_obj = pickle.load(inp)
    
    pro_emb=embedding_obj.pro_emb
    for i in range(len(products)):
        product=products[i][:len(products[i])-1]
        words=list(model.wv.vocab)
        item_embeddings=[]
        for i in range(len(pro_emb)):
            summation=np.zeros(len(words))
            for j in range(len(pro_emb[i])):
                   if pro_emb[i][j] in words:
                         summation[words.index(pro_emb[i][j])]=1
            item_embeddings.append(summation)
        sim=[]
        myproducts=list(dataset["Product_ID"])
        if product not in myproducts:
            continue
        k=myproducts.index(product)
        itemlist.append(k)
        namelist.append(dataset.iloc[k]["Product_Name"])
        for i in range(len(item_embeddings)):
            y=get_sim(item_embeddings[k],item_embeddings[i])
            if math.isnan(y):
                y=0
            sim.append(y)

        top=np.array(sim).argsort()[-40:][::-1]
        count=0
     
        for i in top:
            
            if i not in itemlist and dataset.iloc[i]["Product_Name"] not in namelist:
                recommendation.append(i)
                itemlist.append(i)
                namelist.append(dataset.iloc[i]["Product_Name"])
                count+=1
            if count>=5:
                break
    final_rec=[]
    for i in range(len(recommendation)):
        final_rec.append({"Product_Name":dataset.iloc[recommendation[i]]["Product_Name"],
                         "Price":dataset.iloc[recommendation[i]]["Price"],
                      "IMG":dataset.iloc[recommendation[i]]["IMG"],
                      "Product_ID":dataset.iloc[recommendation[i]]["Product_ID"],
                      "Category":dataset.iloc[recommendation[i]]["Category"],
                      "Ratings":dataset.iloc[recommendation[i]]["Ratings"]
                     
                     })
    
      
    return final_rec


@app.route('/', methods=['GET','PUT','POST'])
@cross_origin(origin='*',headers=['Content-Type','Authorization'])

def index():

    f=open('./items.txt','a')
    f.write('\n')
    f.write(request.data.decode("utf-8")) 

    f.close()

@app.route('/rec/', methods=['GET','PUT','POST'])
# @cross_origin(origin='*',headers=['Content-Type','Authorization'])

def recom():

	file1 = open("items.txt","r") 
	x=file1.readlines()
	return json.dumps(main_Rec(x[len(x)-5:]))
	
	


if __name__ == '__main__':
	app.run(debug=True)